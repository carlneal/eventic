<?php

namespace App\Controller\Dashboard\Attendee;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

class FavoritesController extends Controller {

    /**
     * @Route("/my-favorites", name="favorites")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {

        $events = $paginator->paginate($services->getEvents(array("addedtofavoritesby" => $this->getUser()))->getQuery(), $request->query->getInt('page', 1), 12, array('wrap-queries' => true));
        return $this->render('Dashboard/Attendee/favorites.html.twig', [
                    'events' => $events
        ]);
    }

    //, condition="request.isXmlHttpRequest()"

    /**
     * @Route("/my-favorites/add/{slug}", name="favorites_add", condition="request.isXmlHttpRequest()")
     * @Route("/my-favorites/remove/{slug}", name="favorites_remove", condition="request.isXmlHttpRequest()")
     */
    public function addRemove($slug, AppServices $services, TranslatorInterface $translator) {

        $event = $services->getEvents(array("slug" => $slug))->getQuery()->getOneOrNullResult();
        if (!$event) {
            return new JsonResponse(['error' => $translator->trans('The event can not be found')]);
        }
        $em = $this->getDoctrine()->getManager();
        if ($event->isAddedToFavoritesBy($this->getUser())) {
            $this->getUser()->removeFavorite($event);
            $em->persist($this->getUser());
            $em->flush();
            return new JsonResponse(['success' => $translator->trans('The event has been removed from your favorites')]);
        } else {
            $this->getUser()->addFavorite($event);
            $em->persist($this->getUser());
            $em->flush();
            return new JsonResponse(['success' => $translator->trans('The event has been added to your favorites')]);
        }
    }

}
