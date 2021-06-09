<?php

namespace App\Controller\Dashboard\Shared;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\Event;
use App\Form\EventType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EventController extends Controller {

    /**
     * @Route("/administrator/manage-events", name="dashboard_administrator_event", methods="GET")
     * @Route("/organizer/my-events", name="dashboard_organizer_event", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services, AuthorizationCheckerInterface $authChecker) {
        $slug = ($request->query->get('slug')) == "" ? "all" : $request->query->get('slug');
        $category = ($request->query->get('category')) == "" ? "all" : $request->query->get('category');
        $venue = ($request->query->get('venue')) == "" ? "all" : $request->query->get('venue');
        $elapsed = ($request->query->get('elapsed')) == "" ? "all" : $request->query->get('elapsed');
        $published = ($request->query->get('published')) == "" ? "all" : $request->query->get('published');

        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        $events = $paginator->paginate($services->getEvents(array("slug" => $slug, "category" => $category, "venue" => $venue, "elapsed" => $elapsed, "published" => $published, "organizer" => $organizer, "sort" => "startdate", "organizerEnabled" => "all", "sort" => "e.createdAt", "order" => "DESC"))->getQuery(), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Shared/Event/index.html.twig', [
                    'events' => $events,
        ]);
    }

    /**
     * @Route("/organizer/my-events/add", name="dashboard_organizer_event_add", methods="GET|POST")
     * @Route("/organizer/my-events/{slug}/edit", name="dashboard_organizer_event_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null, AuthorizationCheckerInterface $authChecker) {
        $em = $this->getDoctrine()->getManager();

        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        if (!$slug) {
            $event = new Event();
            $form = $this->createForm(EventType::class, $event, array('validation_groups' => ['create', 'Default']));
        } else {
            $event = $services->getEvents(array('published' => 'all', "elapsed" => "all", 'slug' => $slug, 'organizer' => $organizer, "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();
            if (!$event) {
                $this->addFlash('error', $translator->trans('The event can not be found'));
                return $services->redirectToReferer('event');
            }
            $form = $this->createForm(EventType::class, $event, array('validation_groups' => ['update', 'Default']));
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                foreach ($event->getImages() as $image) {
                    $image->setEvent($event);
                }
                foreach ($event->getEventdates() as $eventdate) {
                    $eventdate->setEvent($event);
                    if (!$slug || !$eventdate->getReference()) {
                        $eventdate->setReference($services->generateReference(10));
                    }
                    foreach ($eventdate->getTickets() as $eventticket) {
                        $eventticket->setEventdate($eventdate);
                        if (!$slug || !$eventticket->getReference()) {
                            $eventticket->setReference($services->generateReference(10));
                        }
                    }
                }
                if (!$slug) {
                    $event->setOrganizer($this->getUser()->getOrganizer());
                    $event->setReference($services->generateReference(10));
                    $this->addFlash('success', $translator->trans('The event has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The event has been successfully updated'));
                }
                $em->persist($event);
                $em->flush();
                if ($authChecker->isGranted('ROLE_ORGANIZER')) {
                    return $this->redirectToRoute("dashboard_organizer_event");
                } elseif ($authChecker->isGranted('ROLE_ADMINISTRATOR')) {
                    return $this->redirectToRoute("dashboard_administrator_event");
                }
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Shared/Event/add-edit.html.twig', array(
                    "event" => $event,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/administrator/manage-events/{slug}/delete-permanently", name="dashboard_administrator_event_delete_permanently", methods="GET")
     * @Route("/administrator/manage-events/{slug}/delete", name="dashboard_administrator_event_delete", methods="GET")
     * @Route("/organizer/my-events/{slug}/delete-permanently", name="dashboard_organizer_event_delete_permanently", methods="GET")
     * @Route("/organizer/my-events/{slug}/delete", name="dashboard_organizer_event_delete", methods="GET")
     */
    public function delete(Request $request, AppServices $services, TranslatorInterface $translator, $slug, AuthorizationCheckerInterface $authChecker) {
        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        $event = $services->getEvents(array("slug" => $slug, "published" => "all", "elapsed" => "all", "organizer" => $organizer, "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$event) {
            $this->addFlash('error', $translator->trans('The event can not be found'));
            return $services->redirectToReferer('event');
        }

        if ($event->getOrderElementsQuantitySum() > 0) {
            $this->addFlash('error', $translator->trans('The event can not be deleted because it has one or more orders'));
            return $services->redirectToReferer('event');
        }
        if ($event->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The event has been deleted permanently'));
        } else {
            $this->addFlash('notice', $translator->trans('The event has been deleted'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();
        return $services->redirectToReferer('event');
    }

    /**
     * @Route("/administrator/manage-events/{slug}/restore", name="dashboard_administrator_event_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $event = $services->getEvents(array("slug" => $slug, "published" => "all", "elapsed" => "all", "organizer" => "all", "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$event) {
            $this->addFlash('error', $translator->trans('The event can not be found'));
            return $services->redirectToReferer('event');
        }
        $event->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();
        $this->addFlash('success', $translator->trans('The event has been succesfully restored'));

        return $services->redirectToReferer('event');
    }

    /**
     * @Route("/organizer/my-events/{slug}/publish", name="dashboard_organizer_event_publish", methods="GET")
     * @Route("/organizer/my-events/{slug}/draft", name="dashboard_organizer_event_draft", methods="GET")
     */
    public function showhide(Request $request, AppServices $services, TranslatorInterface $translator, $slug, AuthorizationCheckerInterface $authChecker) {

        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        $event = $services->getEvents(array("slug" => $slug, "published" => "all", "elapsed" => "all", "organizer" => $organizer, "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$event) {
            $this->addFlash('error', $translator->trans('The event can not be found'));
            return $services->redirectToReferer('event');
        }
        if ($event->getPublished() === true) {
            $event->setPublished(false);
            $this->addFlash('notice', $translator->trans('The event has been unpublished and will not be included in the search results'));
        } else {
            $event->setPublished(true);
            $this->addFlash('success', $translator->trans('The event has been published and will figure in the search results'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();
        return $services->redirectToReferer('event');
    }

    /**
     * @Route("/administrator/manage-events/{slug}/details", name="dashboard_administrator_event_details", methods="GET", condition="request.isXmlHttpRequest()")
     * @Route("/organizer/my-events/{slug}/details", name="dashboard_organizer_event_details", methods="GET", condition="request.isXmlHttpRequest()")
     */
    public function details(AppServices $services, TranslatorInterface $translator, $slug, AuthorizationCheckerInterface $authChecker) {

        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        $event = $services->getEvents(array("slug" => $slug, "published" => "all", "elapsed" => "all", "organizer" => $organizer, "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$event) {
            return new Response($translator->trans('The event can not be found'));
        }
        return $this->render('Dashboard/Shared/Event/details.html.twig', [
                    'event' => $event,
        ]);
    }

}
