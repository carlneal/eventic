<?php

namespace App\Controller\Dashboard\Organizer;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Form\OrganizerProfileType;

class AccountController extends Controller {

    /**
     * @Route("/profile", name="profile", methods="GET|POST")
     */
    public function edit(Request $request, TranslatorInterface $translator) {
        $form = $this->createForm(OrganizerProfileType::class, $this->getUser()->getOrganizer());
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($this->getUser()->getOrganizer());
                $em->flush();
                $this->addFlash('success', $translator->trans('Your organizer profile has been successfully updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Organizer/Account/profile.html.twig', array(
                    "form" => $form->createView()
        ));
    }

}
