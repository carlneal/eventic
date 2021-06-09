<?php

namespace App\Controller\Dashboard\Shared;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Entity\Review;
use App\Form\ReviewType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ReviewController extends Controller {

    /**
     * @Route("/attendee/my-reviews", name="dashboard_attendee_reviews")
     * @Route("/organizer/reviews", name="dashboard_organizer_reviews")
     * @Route("/administrator/manage-reviews", name="dashboard_administrator_reviews")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services, AuthorizationCheckerInterface $authChecker) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');
        $event = ($request->query->get('event')) == "" ? "all" : $request->query->get('event');
        $visible = ($request->query->get('visible')) == "" ? "all" : $request->query->get('visible');
        $rating = ($request->query->get('rating')) == "" ? "all" : $request->query->get('rating');
        $slug = ($request->query->get('slug')) == "" ? "all" : $request->query->get('slug');

        $user = "all";
        if ($authChecker->isGranted('ROLE_ATTENDEE')) {
            $user = $this->getUser()->getSlug();
        }

        $organizer = "all";
        if ($authChecker->isGranted('ROLE_ORGANIZER')) {
            $organizer = $this->getUser()->getOrganizer()->getSlug();
        }

        $reviews = $paginator->paginate($services->getReviews(array("user" => $user, "organizer" => $organizer, "keyword" => $keyword, "event" => $event, "slug" => $slug, "visible" => $visible, "rating" => $rating))->getQuery(), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));
        return $this->render('Dashboard/Shared/Review/reviews.html.twig', [
                    'reviews' => $reviews
        ]);
    }

    /**
     * @Route("/attendee/my-reviews/{slug}/add", name="dashboard_attendee_reviews_add")
     */
    public function add($slug, Request $request, AppServices $services, TranslatorInterface $translator, UrlGeneratorInterface $router) {
        $event = $services->getEvents(array("slug" => $slug, "elapsed" => "all"))->getQuery()->getOneOrNullResult();
        if (!$event) {
            $this->addFlash('error', $translator->trans('The event not be found'));
            return $services->redirectToReferer("events");
        }
        $em = $this->getDoctrine()->getManager();
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $review->setUser($this->getUser());
                $review->setEvent($event);
                $em->persist($review);
                $em->flush();
                $this->addFlash('success', $translator->trans('Your review has been successfully saved'));
                return $this->redirect($router->generate('event', ['slug' => $event->getSlug()]) . '#reviews');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Shared/Review/add.html.twig', array(
                    "event" => $event,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/administrator/manage-reviews/{slug}/show", name="dashboard_administrator_review_show", methods="GET")
     * @Route("/administrator/manage-reviews/{slug}/hide", name="dashboard_administrator_review_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $review = $services->getReviews(array('slug' => $slug, 'visible' => 'all'))->getQuery()->getOneOrNullResult();
        if (!$review) {
            $this->addFlash('error', $translator->trans('The review can not be found'));
            return $services->redirectToReferer('review');
        }
        if ($review->getVisible()) {
            $review->setVisible(false);
            $this->addFlash('notice', $translator->trans('The review has been hidden'));
        } else {
            $review->setVisible(true);
            $this->addFlash('success', $translator->trans('The review has been enabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($review);
        $em->flush();
        return $services->redirectToReferer('review');
    }

    /**
     * @Route("/administrator/manage-reviews/{slug}/delete-permanently", name="dashboard_administrator_review_delete_permanently", methods="GET")
     * @Route("/administrator/manage-reviews/{slug}/delete", name="dashboard_administrator_review_delete", methods="GET")
     */
    public function delete($slug, AppServices $services, TranslatorInterface $translator, AuthorizationCheckerInterface $authChecker) {

        $review = $services->getReviews(array('slug' => $slug, 'visible' => 'all'))->getQuery()->getOneOrNullResult();
        if (!$review) {
            $this->addFlash('error', $translator->trans('The review can not be found'));
            return $services->redirectToReferer('review');
        }
        if ($review->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The review has been deleted permanently'));
        } else {
            $this->addFlash('notice', $translator->trans('The review has been deleted'));
        }
        $em = $this->getDoctrine()->getManager();
        $review->setVisible(false);
        $em->persist($review);
        $em->flush();
        $em->remove($review);
        $em->flush();
        return $services->redirectToReferer('review');
    }

    /**
     * @Route("/administrator/manage-reviews/{slug}/restore", name="dashboard_administrator_review_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $review = $services->getReviews(array('slug' => $slug, 'visible' => 'all'))->getQuery()->getOneOrNullResult();
        if (!$review) {
            $this->addFlash('error', $translator->trans('The review can not be found'));
            return $services->redirectToReferer('review');
        }
        $review->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($review);
        $em->flush();
        $this->addFlash('success', $translator->trans('The review has been succesfully restored'));

        return $services->redirectToReferer('review');
    }

}
