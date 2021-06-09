<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\AppServices;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrganizerController extends AbstractController {

    /**
     * @Route("/organizer/{slug}", name="organizer")
     */
    public function organizer($slug, Request $request, AppServices $services, TranslatorInterface $translator) {

        $user = $services->getUsers(array('organizerslug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$user) {
            $this->addFlash('error', $translator->trans('The organizer not be found'));
            return $services->redirectToReferer("events");
        }

        $em = $this->getDoctrine()->getManager();
        $user->getOrganizer()->viewed();
        $em->persist($user->getOrganizer());
        $em->flush();

        return $this->render('Front/Organizer/profile.html.twig', ['organizer' => $user->getOrganizer()]
        );
    }

}
