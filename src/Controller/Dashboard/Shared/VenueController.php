<?php

namespace App\Controller\Dashboard\Shared;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\Venue;
use App\Form\VenueType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class VenueController extends Controller {

    /**
     * @Route("/administrator/manage-venues", name="dashboard_administrator_venue", methods="GET")
     * @Route("/organizer/my-venues", name="dashboard_organizer_venue", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services, AuthorizationCheckerInterface $authChecker) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');
        $directory = ($request->query->get('directory')) == "" ? "all" : $request->query->get('directory');

        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        $venues = $paginator->paginate($services->getVenues(array('organizer' => $organizer, 'keyword' => $keyword, 'directory' => $directory, 'hidden' => 'all', "organizerEnabled" => "all")), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Shared/Venue/index.html.twig', [
                    'venues' => $venues,
        ]);
    }

    /**
     * @Route("/administrator/manage-venues/add", name="dashboard_administrator_venue_add", methods="GET|POST")
     * @Route("/administrator/manage-venues/{slug}/edit", name="dashboard_administrator_venue_edit", methods="GET|POST")
     * @Route("/organizer/my-venues/add", name="dashboard_organizer_venue_add", methods="GET|POST")
     * @Route("/organizer/my-venues/{slug}/edit", name="dashboard_organizer_venue_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null, AuthorizationCheckerInterface $authChecker) {
        $em = $this->getDoctrine()->getManager();

        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        if (!$slug) {
            $venue = new Venue();
        } else {
            $venue = $services->getVenues(array('organizer' => $organizer, 'hidden' => 'all', 'slug' => $slug, "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();
            if (!$venue) {
                $this->addFlash('error', $translator->trans('The venue can not be found'));
                return $services->redirectToReferer('venue');
            }
        }

        $form = $this->createForm(VenueType::class, $venue);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($authChecker->isGranted('ROLE_ORGANIZER')) {
                    $venue->setOrganizer($this->getUser()->getOrganizer());
                }
                foreach ($venue->getImages() as $image) {
                    $image->setVenue($venue);
                }
                $em->persist($venue);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The venue has been successfully created'));
                    if ($this->isGranted("ROLE_ADMINISTRATOR")) {
                        return $this->redirectToRoute("dashboard_administrator_venue");
                    } else {
                        return $this->redirectToRoute("dashboard_organizer_venue");
                    }
                } else {
                    $this->addFlash('success', $translator->trans('The venue has been successfully updated'));
                    if ($this->isGranted("ROLE_ADMINISTRATOR")) {
                        return $this->redirectToRoute("dashboard_administrator_venue");
                    } else {
                        return $this->redirectToRoute("dashboard_organizer_venue");
                    }
                }
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Shared/Venue/add-edit.html.twig', array(
                    "venue" => $venue,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/administrator/manage-venues/{slug}/disable", name="dashboard_administrator_venue_disable", methods="GET")
     * @Route("/administrator/manage-venues/{slug}/delete", name="dashboard_administrator_venue_delete", methods="GET")
     * @Route("/organizer/my-venues/{slug}/disable", name="dashboard_organizer_venue_disable", methods="GET")
     * @Route("/organizer/my-venues/{slug}/delete", name="dashboard_organizer_venue_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug, AuthorizationCheckerInterface $authChecker) {

        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        $venue = $services->getVenues(array('organizer' => $organizer, 'hidden' => 'all', 'slug' => $slug, "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$venue) {
            $this->addFlash('error', $translator->trans('The venue can not be found'));
            return $services->redirectToReferer('venue');
        }
        if (count($venue->getEventdates()) > 0) {
            $this->addFlash('error', $translator->trans('The venue can not be deleted because it is linked with one or more events'));
            return $services->redirectToReferer('venue');
        }
        if ($venue->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The venue has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The venue has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $venue->setHidden(true);
        $venue->setListedondirectory(false);
        $em->persist($venue);
        $em->flush();
        $em->remove($venue);
        $em->flush();
        return $services->redirectToReferer('venue');
    }

    /**
     * @Route("/administrator/manage-venues/{slug}/restore", name="dashboard_administrator_venue_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $venue = $services->getVenues(array('organizer' => "all", 'hidden' => 'all', 'slug' => $slug, "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$venue) {
            $this->addFlash('error', $translator->trans('The venue can not be found'));
            return $services->redirectToReferer('venue');
        }
        $venue->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($venue);
        $em->flush();
        $this->addFlash('success', $translator->trans('The venue has been succesfully restored'));

        return $services->redirectToReferer('venue');
    }

    /**
     * @Route("/administrator/manage-venues/{slug}/show", name="dashboard_administrator_venue_show", methods="GET")
     * @Route("/administrator/manage-venues/{slug}/hide", name="dashboard_administrator_venue_hide", methods="GET")
     * @Route("/organizer/my-venues/{slug}/show", name="dashboard_organizer_venue_show", methods="GET")
     * @Route("/organizer/my-venues/{slug}/hide", name="dashboard_organizer_venue_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug, AuthorizationCheckerInterface $authChecker) {

        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        $venue = $services->getVenues(array('organizer' => $organizer, 'hidden' => 'all', 'slug' => $slug, "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();

        if (!$venue) {
            $this->addFlash('error', $translator->trans('The venue can not be found'));
            return $services->redirectToReferer('venue');
        }
        if ($venue->getHidden() === true) {
            $venue->setHidden(false);
            $this->addFlash('success', $translator->trans('The venue is visible'));
        } else {
            $venue->setHidden(true);
            $venue->setListedondirectory(false);
            $this->addFlash('error', $translator->trans('The venue is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($venue);
        $em->flush();
        return $services->redirectToReferer('venue');
    }

    /**
     * @Route("/administrator/manage-venues/{slug}/listondirectory", name="dashboard_administrator_venue_listondirectory", methods="GET")
     * @Route("/administrator/manage-venues/{slug}/hidefromdirectory", name="dashboard_administrator_venue_hidefromdirectory", methods="GET")
     */
    public function publicvenuesdirectory(AppServices $services, TranslatorInterface $translator, $slug) {

        $venue = $services->getVenues(array('hidden' => 'all', 'slug' => $slug, "organizerEnabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$venue) {
            $this->addFlash('error', $translator->trans('The venue can not be found'));
            return $services->redirectToReferer('venue');
        }
        if ($venue->getListedondirectory() === true) {
            $venue->setListedondirectory(false);
            $this->addFlash('info', $translator->trans('The venue is hidden from the public venues directory'));
        } else {
            $venue->setListedondirectory(true);
            $this->addFlash('success', $translator->trans('The venue is listed on the public venues directory'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($venue);
        $em->flush();
        return $services->redirectToReferer('venue');
    }

}
