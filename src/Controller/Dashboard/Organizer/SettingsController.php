<?php

namespace App\Controller\Dashboard\Organizer;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\PaymentGateway;
use App\Form\OrganizerPayoutPaymentGatewayType;
use App\Service\AppServices;

class SettingsController extends Controller {

    /**
     * @Route("/settings/scanner-app", name="settings_scanner_app", methods="GET|POST")
     */
    public function scannerApp(Request $request, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('showEventDateStatsOnScannerApp', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show event date stats on the scanner app',
                    'choices' => ['Yes' => 1, 'No' => 0],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'help' => 'The event date stats (sales and attendance) will be visible on the scanner app',
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('allowTapToCheckInOnScannerApp', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Allow tap to check in on the scanner app',
                    'choices' => ['Yes' => 1, 'No' => 0],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'help' => 'Besides the qr code scanning feature, the scanner account will be able to check in the attendees using a list and a button',
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
                ])
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $settings = $form->getData();
                $this->getUser()->getOrganizer()->setShowEventDateStatsOnScannerApp($settings['showEventDateStatsOnScannerApp']);
                $this->getUser()->getOrganizer()->setAllowTapToCheckInOnScannerApp($settings['allowTapToCheckInOnScannerApp']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($this->getUser()->getOrganizer());
                $em->flush();
                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('showEventDateStatsOnScannerApp')->setData($this->getUser()->getOrganizer()->getShowEventDateStatsOnScannerApp());
            $form->get('allowTapToCheckInOnScannerApp')->setData($this->getUser()->getOrganizer()->getAllowTapToCheckInOnScannerApp());
        }

        return $this->render('Dashboard/Organizer/Settings/scanner-app.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/payouts", name="settings_payouts", methods="GET|POST")
     */
    public function payout() {
        return $this->render('Dashboard/Organizer/Settings/payout-methods.html.twig');
    }

    /**
     * @Route("/settings/payouts/add", name="settings_payouts_add", methods="GET|POST")
     * @Route("/settings/payouts/{slug}/edit", name="settings_payouts_edit", methods="GET|POST")
     */
    public function payoutAddEdit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {

        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $factoryName = $request->query->get("factoryName");
            if ($factoryName != "paypal_rest" && $factoryName != "stripe_checkout") {
                $this->addFlash('error', $translator->trans('The payout method can not be found'));
                return $this->redirectToRoute("dashboard_organizer_settings_payouts");
            }
            if (($factoryName == "paypal_rest" && $services->getSetting("organizer_payout_paypal_enabled") == "no") || ($factoryName == "stripe_checkout" && $services->getSetting("organizer_payout_stripe_enabled") == "no")) {
                $this->addFlash('error', $translator->trans('This payout method is currently disabled'));
                return $this->redirectToRoute("dashboard_organizer_settings_payouts");
            }
            $paymentgateway = new PaymentGateway();
            $form = $this->createForm(OrganizerPayoutPaymentGatewayType::class, $paymentgateway);
        } else {
            $paymentgateway = $services->getPaymentGateways(array('organizer' => $this->getUser()->getOrganizer()->getSlug(), 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$paymentgateway) {
                $this->addFlash('error', $translator->trans('The payout method can not be found'));
                return $this->redirectToRoute("dashboard_organizer_settings_payouts");
            }
            $form = $this->createForm(OrganizerPayoutPaymentGatewayType::class, $paymentgateway);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $paymentgateway->setGatewayName($paymentgateway->getFactoryName());
            if ($form->isValid()) {
                if (!$slug) {
                    $paymentgateway->setOrganizer($this->getUser()->getOrganizer());
                    $paymentgateway->setFactoryName($factoryName);
                    if ($factoryName == "paypal_rest") {
                        $paymentgateway->setGatewayName("Paypal");
                        $paymentgateway->setName("Paypal");
                    } else if ($factoryName == "stripe_checkout") {
                        $paymentgateway->setGatewayName("Stripe");
                        $paymentgateway->setName("Stripe");
                    }
                }
                $paymentgateway->setUpdatedAt(new \DateTime);
                $em->persist($paymentgateway);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The payout method has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The payout method has been successfully updated'));
                }
                return $this->redirectToRoute("dashboard_organizer_settings_payouts");
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }

        return $this->render('Dashboard/Organizer/Settings/payout-add-edit.html.twig', [
                    'form' => $form->createView(),
                    'paymentgateway' => $paymentgateway
        ]);
    }

    /**
     * @Route("/settings/payouts/{slug}/unset", name="settings_payouts_unset", methods="GET")
     */
    public function payoutUnset(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {

        $paymentgateway = $services->getPaymentGateways(array('organizer' => $this->getUser()->getOrganizer()->getSlug(), 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$paymentgateway) {
            $this->addFlash('error', $translator->trans('The payout method can not be found'));
            return $this->redirectToRoute("dashboard_organizer_settings_payouts");
        }
        $em = $this->getDoctrine()->getManager();
        $paymentgateway->setEnabled(false);
        $em->persist($paymentgateway);
        $em->flush();
        $this->addFlash('notice', $translator->trans('The payout method is unset'));
        return $this->redirectToRoute("dashboard_organizer_settings_payouts");
    }

}
