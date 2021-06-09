<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AppServices;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints as Assert;

class PageController extends AbstractController {

    /**
     * @Route("/page/{slug}", name="page")
     */
    public function page($slug, AppServices $services, TranslatorInterface $translator) {
        $page = $services->getPages(array('slug' => $slug))->getQuery()->getOneOrNullResult();

        if (!$page) {
            $this->addFlash("error", $translator->trans("The page can not be found"));
            return $this->redirectToRoute("homepage");
        }

        return $this->render('Front/Page/page.html.twig', [
                    "page" => $page
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, TranslatorInterface $translator, \Swift_Mailer $mailer, AppServices $services) {

        $form = $this->createFormBuilder()
                ->add('name', TextType::class, [
                    'required' => true,
                    'label' => 'Name',
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('email', TextType::class, [
                    'required' => true,
                    'label' => 'Email',
                    'constraints' => array(
                        new NotBlank(),
                        new Assert\Email([
                            'checkMX' => true,
                                ])
                    ),
                ])
                ->add('subject', TextType::class, [
                    'required' => true,
                    'label' => 'Subject',
                    'constraints' => array(
                        new NotBlank(),
                        new Length([
                            'min' => 2,
                            'max' => 20,
                            'allowEmptyString' => false,
                                ])
                    ),
                ])
                ->add('message', TextareaType::class, [
                    'required' => true,
                    'label' => 'Message',
                    'attr' => ['rows' => '10'],
                    'constraints' => array(
                        new NotBlank(),
                        new Length([
                            'min' => 10,
                            'max' => 500,
                            'allowEmptyString' => false,
                                ])
                    ),
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Send',
                    'attr' => ['class' => 'btn btn-primary btn-block'],
                ])
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();

                $email = (new \Swift_Message($services->getSetting("website_name") . " contact form"))
                        ->setFrom($services->getSetting('no_reply_email'))
                        ->setTo($services->getSetting("contact_email"))
                        ->setBody("Sender: " . $data["name"] . "\r\n" .
                        "Email: " . $data["email"] . "\r\n" .
                        "Subject: " . $data["subject"] . "\r\n" .
                        "Message: " . $data["message"] . "\r\n");

                $mailer->send($email);

                $this->addFlash('success', $translator->trans('Your message has been successfully sent'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }

        return $this->render('Front/Page/contact.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/access-denied", name="access_denied")
     */
    public function accessDenied() {
        return $this->render('Front/Page/access-denied.html.twig');
    }

}
