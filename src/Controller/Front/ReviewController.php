<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class ReviewController extends Controller {

    /**
     * @Route("/event/{slug}/reviews", name="event_reviews")
     */
    public function eventreviews($slug, Request $request, PaginatorInterface $paginator, AppServices $services, TranslatorInterface $translator) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');

        $event = $services->getEvents(array("slug" => $slug, "elapsed" => "all"))->getQuery()->getOneOrNullResult();
        if (!$event) {
            $this->addFlash('error', $translator->trans('The event not be found'));
            return $services->redirectToReferer("events");
        }

        $reviews = $paginator->paginate($services->getReviews(array("event" => $event->getSlug(), "keyword" => $keyword))->getQuery(), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Front/Event/reviews.html.twig', [
                    'reviews' => $reviews,
                    'event' => $event
        ]);
    }

}
