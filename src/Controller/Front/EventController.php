<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class EventController extends AbstractController {

    /**
     * @Route("/events", name="events")
     */
    public function events(Request $request, PaginatorInterface $paginator, AppServices $services, TranslatorInterface $translator) {

        $category = "all";
        $categorySlug = $request->query->get('category') == "" ? "all" : $request->query->get('category');
        $keyword = $request->query->get('keyword') == "" ? "all" : $request->query->get('keyword');
        $localonly = $request->query->get('localonly') == "" ? "all" : $request->query->get('localonly');
        $country = $request->query->get('country') == "" ? "all" : $request->query->get('country');
        $location = $request->query->get('location') == "" ? "all" : $request->query->get('location');
        $startdate = $request->query->get('startdate') == "" ? "all" : $request->query->get('startdate');
        $freeonly = $request->query->get('freeonly') == "" ? "all" : $request->query->get('freeonly');
        $pricemin = $request->query->get('pricemin') == "" || $request->query->get('pricemin') == "0" ? "all" : $request->query->get('pricemin');
        $pricemax = $request->query->get('pricemax') == "" || $request->query->get('pricemax') == "10000" ? "all" : $request->query->get('pricemax');
        $audience = $request->query->get('audience') == "" ? "all" : $request->query->get('audience');
        $organizer = $request->query->get('organizer') == "" ? "all" : $request->query->get('organizer');
        $onlineonly = $request->query->get('onlineonly') == "" ? "all" : $request->query->get('onlineonly');
        if ($categorySlug != "all") {
            $category = $services->getCategories(array("slug" => $categorySlug))->getQuery()->getOneOrNullresult();
            if (!$category) {
                $this->addFlash('error', $translator->trans('The category can not be found'));
                return $this->redirectToRoute('events');
            }
        }

        $events = $paginator->paginate($services->getEvents(array("category" => $categorySlug, 'keyword' => $keyword, 'localonly' => $localonly, 'country' => $country, 'location' => $location, 'startdate' => $startdate, 'pricemin' => $pricemin, 'pricemax' => $pricemax, 'audience' => $audience, 'organizer' => $organizer, 'freeonly' => $freeonly, 'onlineonly' => $onlineonly))->getQuery(), $request->query->getInt('page', 1), $services->getSetting("events_per_page"), array('wrap-queries' => true));

        return $this->render('Front/Event/events.html.twig', [
                    'events' => $events,
                    'category' => $category,
        ]);
    }

    /**
     * @Route("/event/{slug}", name="event")
     */
    public function event($slug, AppServices $services, TranslatorInterface $translator) {

        if ($this->isGranted("ROLE_ADMINISTRATOR")) {
            $event = $services->getEvents(array("slug" => $slug, "elapsed" => "all", "published" => "all"))->getQuery()->getOneOrNullResult();
        } elseif ($this->isGranted("ROLE_ORGANIZER")) {
            $event = $services->getEvents(array("slug" => $slug, "elapsed" => "all", "published" => "all"))->getQuery()->getOneOrNullResult();
            if ($event) {
                if ($event->getOrganizer() != $this->getUser()->getOrganizer() && $event->getPublished() == false) {
                    $event = null;
                }
            }
        } else {
            $event = $services->getEvents(array("slug" => $slug, "elapsed" => "all"))->getQuery()->getOneOrNullResult();
        }

        if (!$event) {
            $this->addFlash('error', $translator->trans('The event not be found'));
            return $this->redirectToRoute('events');
        }
        $event->viewed();
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();
        return $this->render('Front/Event/event.html.twig', ["event" => $event]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function categories() {
        return $this->render('Front/Event/categories.html.twig');
    }

}
