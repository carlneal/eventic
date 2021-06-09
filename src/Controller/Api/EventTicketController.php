<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\AppServices;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EventTicketController extends Controller {

    /**
     * @Route("event/{eventSlug}/event-date/{eventDateReference}/get-tickets", name="get_eventtickets_by_eventdate")
     */
    public function getEventTickets($eventSlug, Request $request, $eventDateReference, AppServices $services): Response {
        if ($this->isGranted("ROLE_ATTENDEE") || !$this->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            throw new AccessDeniedHttpException();
        }
        $organizer = "all";
        if ($this->isGranted("ROLE_ORGANIZER")) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }
        $limit = ($request->query->get('limit')) == "" ? 10 : $request->query->get('limit');
        $eventTickets = $services->getEventTickets(array("organizer" => $organizer, "event" => $eventSlug, "eventdate" => $eventDateReference, "limit" => $limit))->getQuery()->getResult();
        $results = array();
        foreach ($eventTickets as $eventTicket) {
            $result = array(
                'id' => $eventTicket->getReference(),
                'text' => $eventTicket->getName());
            array_push($results, $result);
        }
        return $this->json($results);
    }

    /**
     * @Route("/get-event-ticket/{reference}", name="get_eventticket")
     */
    public function getEventTicket($reference = null, Request $request, AppServices $services): Response {
        if ($this->isGranted("ROLE_ATTENDEE") || !$this->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            throw new AccessDeniedHttpException();
        }
        $organizer = "all";
        if ($this->isGranted("ROLE_ORGANIZER")) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }
        $eventTicket = $services->getEventTickets(array("organizer" => $organizer, 'reference' => $reference))->getQuery()->getOneOrNullResult();
        if (!$eventTicket)
            return $this->json(array());
        return $this->json(array("id" => $eventTicket->getReference(), "text" => $eventTicket->getName()));
    }

}
