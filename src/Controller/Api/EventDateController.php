<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\AppServices;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EventDateController extends Controller {

    /**
     * @Route("event/{eventSlug}/get-event-dates", name="get_eventdates_by_event")
     */
    public function getEventDates($eventSlug, Request $request, AppServices $services): Response {
        if ($this->isGranted("ROLE_ATTENDEE") || !$this->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            throw new AccessDeniedHttpException();
        }
        $organizer = "all";
        if ($this->isGranted("ROLE_ORGANIZER")) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }
        $limit = ($request->query->get('limit')) == "" ? 10 : $request->query->get('limit');

        $eventDates = $services->getEventDates(array("organizer" => $organizer, "event" => $eventSlug))->getQuery()->getResult();
        $results = array();
        foreach ($eventDates as $eventDate) {
            $result = array(
                'id' => $eventDate->getReference(),
                'text' => $eventDate->getEvent()->getName() . ' (' . date($this->getParameter("date_format_simple"), $eventDate->getStartdate()->getTimestamp()) . ')');
            array_push($results, $result);
        }
        return $this->json($results);
    }

    /**
     * @Route("/get-event-date/{reference}", name="get_eventdate")
     */
    public function getEventDate($reference = null, Request $request, AppServices $services): Response {
        if ($this->isGranted("ROLE_ATTENDEE") || !$this->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            throw new AccessDeniedHttpException();
        }
        $organizer = "all";
        if ($this->isGranted("ROLE_ORGANIZER")) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }
        $eventDate = $services->getEventDates(array("organizer" => $organizer, 'reference' => $reference))->getQuery()->getOneOrNullResult();
        if (!$eventDate)
            return $this->json(array());
        return $this->json(array("id" => $eventDate->getReference(), "text" => $eventDate->getEvent()->getName() . ' (' . date($this->getParameter("date_format_simple"), $eventDate->getStartdate()->getTimestamp()) . ')'));
    }

    /**
     * @Route("dashboard/pointofsale/get-event-dates-onsale", name="dashboard_pointofsale_get_eventdates")
     */
    public function getPosEventDates(AppServices $services): Response {
        if (!$this->isGranted("ROLE_POINTOFSALE")) {
            throw new AccessDeniedHttpException();
        }
        $events = $services->getEvents(array("onsalebypos" => $this->getUser()->getPointofsale()))->getQuery()->getResult();
        $results = array();
        foreach ($events as $event) {
            if ($event->hasAnEventDateOnSale()) {
                foreach ($event->getEventdates() as $eventDate) {
                    if ($eventDate->isOnSaleByPos($this->getUser()->getPointofsale())) {
                        $result = array(
                            'id' => $eventDate->getReference(),
                            'text' => $eventDate->getEvent()->getName() . ' (' . date($this->getParameter("date_format_simple"), $eventDate->getStartdate()->getTimestamp()) . ')');
                        array_push($results, $result);
                    }
                }
            }
        }
        return $this->json($results);
    }

}
