<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\AppServices;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Contracts\Translation\TranslatorInterface;

class ScannerController extends Controller {

    /**
     * @Route("/login", name="api_scanner_login")
     */
    public function login(Request $request, AppServices $services, UserPasswordEncoderInterface $passwordEncoder, Packages $assetsManager, TranslatorInterface $translator): Response {

        $username = $request->query->get('username');
        $password = $request->query->get('password');
        $user = $services->getUsers(array("username" => $username, "role" => "scanner", "enabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$user) {
            return $this->json(array("type" => "error", "message" => $translator->trans("Invalid credentials")));
        }
        if (!$passwordEncoder->isPasswordValid($user, $password)) {
            return $this->json(array("type" => "error", "message" => $translator->trans("Invalid credentials")));
        }
        if (!$user->isEnabled()) {
            return $this->json(array("type" => "error", "message" => $translator->trans("The scanner account is disabled by the organizer")));
        }
        if (!$user->getApiKey()) {
            $user->setApiKey($services->generateReference(50));
        }
        $user->setLastLogin(new \DateTime);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        if ($user->getScanner()->getOrganizer()->getLogoName()) {
            $organizerLogo = $baseUrl . "/" . $assetsManager->getUrl($user->getScanner()->getOrganizer()->getLogoPath());
        } else {
            $organizerLogo = $user->getScanner()->getOrganizer()->getLogoPlaceholder();
        }

        $events = $services->getEvents(array("canbescannedby" => $user->getScanner()))->getQuery()->getResult();
        $eventDatesArray = array();
        $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        foreach ($events as $event) {
            foreach ($event->getEventdates() as $eventDate) {
                if ($eventDate->canBeScannedBy($user->getScanner())) {
                    $eventDateArray = array();
                    $eventDateArray['eventName'] = $event->getName();

                    $date = "";
                    if ($eventDate->getStartdate()) {
                        $date = date($this->getParameter("date_format_simple"), $eventDate->getStartdate()->getTimestamp());
                    }

                    $eventDateArray['eventDate'] = $date;
                    if ($eventDate->getVenue()) {
                        $eventDateArray['eventVenue'] = $eventDate->getVenue()->getName() . ": " . $eventDate->getVenue()->stringifyAddress();
                    }
                    $eventDateArray['eventImage'] = $baseUrl . "/" . $assetsManager->getUrl($event->getImagePath());
                    $eventDateArray['eventDateReference'] = $eventDate->getReference();
                    $eventDateArray['totalSales'] = $eventDate->getOrderElementsQuantitySum();
                    $eventDateArray['totalQuantity'] = $eventDate->getTicketsQuantitySum();
                    $eventDateArray['totalCheckIns'] = $eventDate->getScannedTicketsCount();
                    $eventDateArray['totalSalesPercentage'] = $eventDate->getTotalSalesPercentage();
                    $eventDateArray['totalCheckInPercentage'] = $eventDate->getTotalCheckInPercentage();
                    array_push($eventDatesArray, $eventDateArray);
                }
            }
        }

        return $this->json(array(
                    "type" => "success",
                    "apiKey" => $user->getApiKey(),
                    "scannerName" => $user->getScanner()->getName(),
                    "username" => $user->getUsername(),
                    "organizerName" => $user->getScanner()->getOrganizer()->getName(),
                    "organizerLogo" => $organizerLogo,
                    "showEventDateStats" => $user->getScanner()->getOrganizer()->getShowEventDateStatsOnScannerApp(),
                    "allowTapToCheckIn" => $user->getScanner()->getOrganizer()->getAllowTapToCheckInOnScannerApp(),
                    "eventDatesArray" => $eventDatesArray,
        ));
    }

    /**
     * @Route("/scanner/get-event-date-attendees/{reference}", name="api_scanner_get_event_date_attendees")
     */
    public function getEventDateAttendees($reference, Request $request, AppServices $services, TranslatorInterface $translator): Response {

        $eventDate = $services->getEventDates(array("organizer" => $this->getUser()->getScanner()->getOrganizer()->getSlug(), "reference" => $reference))->getQuery()->getOneOrNullResult();
        if (!$eventDate) {
            return $this->json(array("type" => "error", "message" => $translator->trans("The event date can not be found")));
        }

        $keyword = ($request->request->get('keyword')) == "" ? "all" : $request->request->get('keyword');
        $checkedin = ($request->request->get('checkedin')) == "" ? "all" : $request->request->get('checkedin');
        $tickets = $services->getOrderTickets(array("eventdate" => $reference, "keyword" => $keyword, "checkedin" => $checkedin))->getQuery()->getResult();

        $attendeesArray = array();
        foreach ($tickets as $ticket) {

            if ($ticket->getOrderelement()->getOrder()->getPayment()->getFirstname() && $ticket->getOrderelement()->getOrder()->getPayment()->getLastname()) {
                $attendeeName = $ticket->getOrderelement()->getOrder()->getPayment()->getFirstname() . " " . $ticket->getOrderelement()->getOrder()->getPayment()->getLastname();
            } else {
                $attendeeName = $ticket->getOrderelement()->getOrder()->getUser()->getCrossRoleName();
            }

            $attendeeArray['ticketReference'] = $ticket->getReference();
            $attendeeArray['attendeeName'] = $attendeeName;
            $attendeeArray['isTicketScanned'] = $ticket->getScanned();
            array_push($attendeesArray, $attendeeArray);
        }
        return $this->json($attendeesArray);
    }

    /**
     * @Route("/scanner/event-date/{eventDateReference}/grant-access/{ticketReference}", name="api_scanner_grant_access")
     */
    public function grantAccess($eventDateReference, $ticketReference, Request $request, AppServices $services, TranslatorInterface $translator): Response {

        $eventDate = $services->getEventDates(array("organizer" => $this->getUser()->getScanner()->getOrganizer()->getSlug(), "reference" => $eventDateReference))->getQuery()->getOneOrNullResult();
        if (!$eventDate) {
            return $this->json(array("type" => "error", "message" => $translator->trans("The event date can not be found")));
        }
        $ticket = $services->getOrderTickets(array("reference" => $ticketReference))->getQuery()->getOneOrNullResult();
        if (!$ticket) {
            return $this->json(array("type" => "error", "message" => $translator->trans("The ticket can not be found")));
        }
        if ($ticket->getOrderelement()->getEventticket()->getEventdate() != $eventDate) {
            return $this->json(array("type" => "error", "message" => $translator->trans("The ticket is not valid for this event date")));
        }
        if ($ticket->getScanned()) {
            return $this->json(array("type" => "error", "message" => $translator->trans("The ticket was already scanned at") . " " . date($this->getParameter("date_format_simple"), $ticket->getUpdatedAt()->getTimestamp())));
        }

        $ticket->setScanned(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($ticket);
        $em->flush();

        return $this->json(array("type" => "success", "message" => $translator->trans("Access granted")));
    }

}
