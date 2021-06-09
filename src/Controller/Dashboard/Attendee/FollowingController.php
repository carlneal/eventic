<?php

namespace App\Controller\Dashboard\Attendee;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

class FollowingController extends Controller {

    /**
     * @Route("/following", name="following")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $users = $paginator->paginate($services->getUsers(array("followedby" => $this->getUser()))->getQuery(), $request->query->getInt('page', 1), 12, array('wrap-queries' => true));
        return $this->render('Dashboard/Attendee/following.html.twig', [
                    'users' => $users
        ]);
    }

    /**
     * @Route("/following/add/{slug}", name="following_add", condition="request.isXmlHttpRequest()")
     * @Route("/following/remove/{slug}", name="following_remove", condition="request.isXmlHttpRequest()")
     */
    public function addRemove($slug, AppServices $services, TranslatorInterface $translator) {

        $user = $services->getUsers(array("organizerslug" => $slug))->getQuery()->getOneOrNullResult();
        if (!$user) {
            return new JsonResponse(['error' => $translator->trans('The organizer can not be found')]);
        }
        $em = $this->getDoctrine()->getManager();
        if ($user->getOrganizer()->isFollowedBy($this->getUser())) {
            $user->getOrganizer()->removeFollowedby($this->getUser());
            $em->persist($user->getOrganizer());
            $em->flush();
            return new JsonResponse(['success' => $translator->trans('You are no longer following this organizer')]);
        } else {
            $user->getOrganizer()->addFollowedby($this->getUser());
            $em->persist($user->getOrganizer());
            $em->flush();
            return new JsonResponse(['success' => $translator->trans('You are following this organizer')]);
        }
    }

}
