<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Currency;
use App\Entity\PaymentGateway;
use App\Service\AppServices;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Form\HomepageHeroSettingsType;
use App\Form\PaymentGatewayType;
use App\Form\AppLayoutSettingsType;
use App\Form\MenuType;

class SettingsController extends Controller {

    /**
     * @Route("/settings/payment", name="settings_payment", methods="GET|POST")
     */
    public function payment(Request $request, AppServices $services, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('currency', EntityType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'class' => Currency::class,
                    'choice_label' => 'ccy',
                    'label' => 'Currency',
                    'attr' => ['class' => 'select2'],
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('position', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Currency symbol position',
                    'choices' => ['Left' => 'left', 'Right' => 'right'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('ticket_fee_online', TextType::class, [
                    'required' => true,
                    'label' => 'Ticket fee (Online)',
                    'help' => 'This fee will be added to the ticket sale price which are bought online, put 0 to disable additional fees for tickets which are bought online, does not apply for free tickets, will be applied to future orders',
                    'attr' => ['class' => 'touchspin-decimal', 'data-min' => 0, "data-max" => 1000000],
                ])
                ->add('ticket_fee_pos', TextType::class, [
                    'required' => true,
                    'label' => 'Ticket fee (Point Of Sale)',
                    'help' => 'This fee will be added to the ticket sale price which are bought from a point of sale, put 0 to disable additional fees for tickets which are bought from a point of sale, does not apply for free tickets, will be applied to future orders',
                    'attr' => ['class' => 'touchspin-decimal', 'data-min' => 0, "data-max" => 1000000],
                ])
                ->add('online_ticket_price_percentage_cut', TextType::class, [
                    'required' => true,
                    'label' => 'Ticket price percentage cut (Online)',
                    'help' => 'This percentage will be deducted from each ticket sold online, upon organizer payout request, this percentage will be taken from each ticket sold online, will be applied to future orders',
                    'attr' => ['class' => 'touchspin-integer', 'data-min' => 0, "data-max" => 100],
                ])
                ->add('pos_ticket_price_percentage_cut', TextType::class, [
                    'required' => true,
                    'label' => 'Ticket price percentage cut (Point of sale)',
                    'help' => 'This percentage will be deducted from each ticket sold on a point of sale, upon organizer payout request, this percentage will be taken from each ticket sold on a point of sale, will be applied to future orders',
                    'attr' => ['class' => 'touchspin-integer', 'data-min' => 0, "data-max" => 100],
                ])
                ->add('organizer_payout_paypal_enabled', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Allow Paypal as a payout method for the organizers to receive their revenue',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('organizer_payout_stripe_enabled', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Allow Stripe as a payout method for the organizers to receive their revenue',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
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
                $services->setSetting("currency_ccy", $settings['currency']->getCcy());
                $services->setSetting("currency_symbol", $settings['currency']->getSymbol());
                $services->setSetting("currency_position", $settings['position']);
                $services->setSetting("ticket_fee_online", $settings['ticket_fee_online']);
                $services->setSetting("ticket_fee_pos", $settings['ticket_fee_pos']);
                $services->setSetting("organizer_payout_paypal_enabled", $settings['organizer_payout_paypal_enabled']);
                $services->setSetting("organizer_payout_stripe_enabled", $settings['organizer_payout_stripe_enabled']);
                $services->setSetting("online_ticket_price_percentage_cut", $settings['online_ticket_price_percentage_cut']);
                $services->setSetting("pos_ticket_price_percentage_cut", $settings['pos_ticket_price_percentage_cut']);
                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('currency')->setData($this->getDoctrine()->getManager()->getRepository("App\Entity\Currency")->findOneByCcy($services->getSetting("currency_ccy")));
            $form->get('position')->setData($services->getSetting("currency_position"));
            $form->get('ticket_fee_online')->setData($services->getSetting("ticket_fee_online"));
            $form->get('ticket_fee_pos')->setData($services->getSetting("ticket_fee_pos"));
            $form->get('organizer_payout_paypal_enabled')->setData($services->getSetting("organizer_payout_paypal_enabled"));
            $form->get('organizer_payout_stripe_enabled')->setData($services->getSetting("organizer_payout_stripe_enabled"));
            $form->get('online_ticket_price_percentage_cut')->setData($services->getSetting("online_ticket_price_percentage_cut"));
            $form->get('pos_ticket_price_percentage_cut')->setData($services->getSetting("pos_ticket_price_percentage_cut"));
        }

        return $this->render('Dashboard/Administrator/Settings/payment.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/checkout", name="settings_checkout", methods="GET|POST")
     */
    public function checkout(Request $request, AppServices $services, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('checkout_timeleft', TextType::class, [
                    'required' => true,
                    'label' => 'Timeleft',
                    'constraints' => array(
                        new NotBlank()
                    ),
                    'attr' => ['class' => 'touchspin-integer', 'data-min' => 100, 'data-max' => 3600],
                    'help' => 'Number of seconds before the reserved tickets are released if the order is still awaiting payment'
                ])
                ->add('show_tickets_left_on_cart_modal', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show tickets left count on cart modal',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
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
                $services->setSetting("checkout_timeleft", $settings['checkout_timeleft']);
                $services->setSetting("show_tickets_left_on_cart_modal", $settings['show_tickets_left_on_cart_modal']);
                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('checkout_timeleft')->setData($services->getSetting("checkout_timeleft"));
            $form->get('show_tickets_left_on_cart_modal')->setData($services->getSetting("show_tickets_left_on_cart_modal"));
        }

        return $this->render('Dashboard/Administrator/Settings/checkout.html.twig', array(
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/settings/payment/gateways/add", name="settings_payment_gateways_add", methods="GET|POST")
     * @Route("/settings/payment/gateways/{slug}/edit", name="settings_payment_gateways_edit", methods="GET|POST")
     */
    public function paymentgatewaysaddedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $paymentgateway = new PaymentGateway();
            $form = $this->createForm(PaymentGatewayType::class, $paymentgateway, array('validation_groups' => 'create'));
        } else {
            $paymentgateway = $services->getPaymentGateways(array('enabled' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            $form = $this->createForm(PaymentGatewayType::class, $paymentgateway, array('validation_groups' => 'update'));
            if (!$paymentgateway) {
                $this->addFlash('error', $translator->trans('The payment gateway can not be found'));
                return $this->redirectToRoute("dashboard_administrator_settings_payment");
            }
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $paymentgateway->setGatewayName($paymentgateway->getFactoryName());
            if ($form->isValid()) {
                $em->persist($paymentgateway);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The payment gateway has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The payment gateway has been successfully updated'));
                }
                return $this->redirectToRoute("dashboard_administrator_settings_payment");
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/Settings/payment-gateway-add-edit.html.twig', array(
                    "paymentgateway" => $paymentgateway,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/settings/newsletter", name="settings_newsletter", methods="GET|POST")
     */
    public function newsletter(Request $request, AppServices $services, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('newsletter_enabled', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Enable newsletter',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'help' => 'SSL must be activated on your hosting server in order to use Mailchimp',
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('mailchimp_api_key', TextType::class, [
                    'required' => false,
                    'label' => 'Mailchimp app id',
                    'help' => 'Go to the documentation to get help about getting an api key'
                ])
                ->add('mailchimp_list_id', TextType::class, [
                    'required' => false,
                    'label' => 'Mailchimp list id',
                    'help' => 'Go to the documentation to get help about getting a list id'
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
                $services->setSetting("newsletter_enabled", $settings['newsletter_enabled']);
                $services->setSetting("mailchimp_api_key", $settings['mailchimp_api_key']);
                $services->setSetting("mailchimp_list_id", $settings['mailchimp_list_id']);
                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('newsletter_enabled')->setData($services->getSetting("newsletter_enabled"));
            $form->get('mailchimp_api_key')->setData($services->getSetting("mailchimp_api_key"));
            $form->get('mailchimp_list_id')->setData($services->getSetting("mailchimp_list_id"));
        }

        return $this->render('Dashboard/Administrator/Settings/newsletter.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/homepage-hero", name="settings_homepage", methods="GET|POST")
     */
    public function homepagehero(Request $request, AppServices $services, TranslatorInterface $translator) {

        $em = $this->getDoctrine()->getManager();
        $homepageherosettings = $em->getRepository("App\Entity\HomepageHeroSettings")->find(1);
        if (!$homepageherosettings) {
            $services->redirectToReferer("index");
            $this->addFlash('error', $translator->trans('The homepage settings could not be loaded'));
        }
        $form = $this->createForm(HomepageHeroSettingsType::class, $homepageherosettings);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $homeSliderEvents = $services->getEvents(array("isOnHomepageSlider" => true))->getQuery()->getResult();
                foreach ($homeSliderEvents as $event) {
                    $event->setIsonhomepageslider(null);
                    $em->persist($event);
                }
                $em->flush();
                foreach ($homepageherosettings->getEvents() as $event) {
                    $event->setIsonhomepageslider($homepageherosettings);
                    $em->persist($event);
                }

                $homeSliderOrganizers = $services->getUsers(array("isOnHomepageSlider" => true, "role" => "organizer"))->getQuery()->getResult();
                foreach ($homeSliderOrganizers as $user) {
                    $user->setIsorganizeronhomepageslider(null);
                    $em->persist($user);
                }
                $em->flush();
                foreach ($homepageherosettings->getOrganizers() as $organizer) {
                    $organizer->setIsorganizeronhomepageslider($homepageherosettings);
                    $em->persist($organizer);
                }

                $em->persist($homepageherosettings);
                $em->flush();

                $settings = $request->request->all()['homepage_hero_settings'];
                $services->setSetting("homepage_show_search_box", $settings['homepage_show_search_box']);
                $services->setSetting("homepage_events_number", $settings['homepage_events_number']);
                $services->setSetting("homepage_categories_number", $settings['homepage_categories_number']);
                $services->setSetting("homepage_blogposts_number", $settings['homepage_blogposts_number']);
                $services->setSetting("homepage_show_call_to_action", $settings['homepage_show_call_to_action']);

                $this->addFlash('success', $translator->trans('The settings have been updated'));
                return $this->redirectToRoute('dashboard_administrator_settings_homepage');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {

            $form->get('homepage_show_search_box')->setData($services->getSetting("homepage_show_search_box"));
            $form->get('homepage_events_number')->setData($services->getSetting("homepage_events_number"));
            $form->get('homepage_categories_number')->setData($services->getSetting("homepage_categories_number"));
            $form->get('homepage_blogposts_number')->setData($services->getSetting("homepage_blogposts_number"));
            $form->get('homepage_show_call_to_action')->setData($services->getSetting("homepage_show_call_to_action"));
        }

        return $this->render('Dashboard/Administrator/Settings/homepage.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/layout", name="settings_layout", methods="GET|POST")
     */
    public function layout(Request $request, AppServices $services, TranslatorInterface $translator) {

        $em = $this->getDoctrine()->getManager();

        $appLayoutSettings = $em->getRepository("App\Entity\AppLayoutSettings")->find(1);
        if (!$appLayoutSettings) {
            $services->redirectToReferer("index");
            $this->addFlash('error', $translator->trans('The layout settings could not be loaded'));
        }
        $form = $this->createForm(AppLayoutSettingsType::class, $appLayoutSettings);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $settings = $request->request->all()['app_layout_settings'];
            if (!array_key_exists('app_locales', $settings)) {
                $form->get('app_locales')->addError(new \Symfony\Component\Form\FormError($translator->trans('You must specify at least one language')));
            } else {
                if (!in_array($settings['default_locale'], $settings['app_locales'])) {
                    $form->get('default_locale')->addError(new \Symfony\Component\Form\FormError($translator->trans('The default locale must be selected in the available languages')));
                }
            }

            if ($form->isValid()) {
                $em->persist($appLayoutSettings);
                $em->flush();

                $services->setSetting("maintenance_mode_custom_message", $settings['maintenance_mode_custom_message']);
                $services->setSetting("date_format", $settings['date_format']);
                $services->setSetting("date_format_simple", $settings['date_format_simple']);
                $services->setSetting("date_format_date_only", $settings['date_format_date_only']);
                $services->setSetting("date_timezone", $settings['date_timezone']);
                $services->setSetting("date_timezone", $settings['date_timezone']);
                $services->setSetting("default_locale", $settings['default_locale']);
                $services->setSetting("app_locales", in_array('app_locales', $settings) ? $settings['app_locales'] : '');
                $services->setSetting("website_name", $settings['website_name']);
                $services->setSetting("website_slug", $settings['website_slug']);
                $services->setSetting("website_url", $settings['website_url']);
                $services->setSetting("website_root_url", $settings['website_root_url']);
                $services->setSetting("website_description_en", $settings['website_description_en']);
                $services->setSetting("website_description_fr", $settings['website_description_fr']);
                $services->setSetting("website_description_es", $settings['website_description_es']);
                $services->setSetting("website_description_ar", $settings['website_description_ar']);
                $services->setSetting("website_keywords_en", $settings['website_keywords_en']);
                $services->setSetting("website_keywords_fr", $settings['website_keywords_fr']);
                $services->setSetting("website_keywords_es", $settings['website_keywords_es']);
                $services->setSetting("website_keywords_ar", $settings['website_keywords_ar']);
                $services->setSetting("contact_email", $settings['contact_email']);
                $services->setSetting("contact_phone", $settings['contact_phone']);
                $services->setSetting("contact_fax", $settings['contact_fax']);
                $services->setSetting("contact_address", $settings['contact_address']);
                $services->setSetting("facebook_url", $settings['facebook_url']);
                $services->setSetting("instagram_url", $settings['instagram_url']);
                $services->setSetting("youtube_url", $settings['youtube_url']);
                $services->setSetting("twitter_url", $settings['twitter_url']);
                $services->setSetting("app_layout", $settings['app_layout']);
                $services->setSetting("app_theme", $settings['app_theme']);
                $services->setSetting("primary_color", $settings['primary_color']);
                $services->setSetting("no_reply_email", $settings['no_reply_email']);
                $services->setSetting("custom_css", $settings['custom_css']);
                $services->setSetting("google_analytics_code", $settings['google_analytics_code']);
                $services->setSetting("show_back_to_top_button", $settings['show_back_to_top_button']);
                $services->setSetting("show_terms_of_service_page", $settings['show_terms_of_service_page']);
                $services->setSetting("terms_of_service_page_slug", $settings['terms_of_service_page_slug']);
                $services->setSetting("show_privacy_policy_page", $settings['show_privacy_policy_page']);
                $services->setSetting("privacy_policy_page_slug", $settings['privacy_policy_page_slug']);
                $services->setSetting("show_cookie_policy_page", $settings['show_cookie_policy_page']);
                $services->setSetting("cookie_policy_page_slug", $settings['cookie_policy_page_slug']);
                $services->setSetting("show_cookie_policy_bar", $settings['show_cookie_policy_bar']);
                $services->setSetting("show_gdpr_compliance_page", $settings['show_gdpr_compliance_page']);
                $services->setSetting("gdpr_compliance_page_slug", $settings['gdpr_compliance_page_slug']);

                $services->updateEnv("APP_ENV", $settings['app_environment']);
                $services->updateEnv("APP_DEBUG", $settings['app_debug']);
                $services->updateEnv("APP_SECRET", $settings['app_secret']);
                $services->updateEnv("MAINTENANCE_MODE", $settings['maintenance_mode']);
                $services->updateEnv("DATE_FORMAT", $settings['date_format']);
                $services->updateEnv("DATE_FORMAT_SIMPLE", $settings['date_format_simple']);
                $services->updateEnv("DATE_FORMAT_DATE_ONLY", $settings['date_format_date_only']);
                $services->updateEnv("DATE_TIMEZONE", $settings['date_timezone']);
                $services->updateEnv("DEFAULT_LOCALE", $settings['default_locale']);
                $services->updateEnv("APP_LOCALES", implode("|", $settings['app_locales']) . "|");

                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('app_environment')->setData($services->getEnv("APP_ENV"));
            $form->get('app_debug')->setData($services->getEnv("APP_DEBUG"));
            $form->get('app_secret')->setData($services->getEnv("APP_SECRET"));
            $form->get('maintenance_mode')->setData($services->getEnv("MAINTENANCE_MODE"));
            $form->get('date_format')->setData($services->getEnv("DATE_FORMAT"));
            $form->get('date_format_simple')->setData($services->getEnv("DATE_FORMAT_SIMPLE"));
            $form->get('date_format_date_only')->setData($services->getEnv("DATE_FORMAT_DATE_ONLY"));
            $form->get('date_timezone')->setData($services->getEnv("DATE_TIMEZONE"));
            $form->get('default_locale')->setData($services->getEnv("DEFAULT_LOCALE"));
            $form->get('app_locales')->setData(array_filter(explode("|", $services->getEnv("APP_LOCALES"))));

            $form->get('maintenance_mode_custom_message')->setData($services->getSetting("maintenance_mode_custom_message"));
            $form->get('website_name')->setData($services->getSetting("website_name"));
            $form->get('website_slug')->setData($services->getSetting("website_slug"));
            $form->get('website_url')->setData($services->getSetting("website_url"));
            $form->get('website_root_url')->setData($services->getSetting("website_root_url"));
            $form->get('website_description_en')->setData($services->getSetting("website_description_en"));
            $form->get('website_description_fr')->setData($services->getSetting("website_description_fr"));
            $form->get('website_description_es')->setData($services->getSetting("website_description_es"));
            $form->get('website_description_ar')->setData($services->getSetting("website_description_ar"));
            $form->get('website_keywords_en')->setData($services->getSetting("website_keywords_en"));
            $form->get('website_keywords_fr')->setData($services->getSetting("website_keywords_fr"));
            $form->get('website_keywords_es')->setData($services->getSetting("website_keywords_es"));
            $form->get('website_keywords_ar')->setData($services->getSetting("website_keywords_ar"));
            $form->get('contact_email')->setData($services->getSetting("contact_email"));
            $form->get('contact_phone')->setData($services->getSetting("contact_phone"));
            $form->get('contact_fax')->setData($services->getSetting("contact_fax"));
            $form->get('contact_address')->setData($services->getSetting("contact_address"));
            $form->get('facebook_url')->setData($services->getSetting("facebook_url"));
            $form->get('instagram_url')->setData($services->getSetting("instagram_url"));
            $form->get('youtube_url')->setData($services->getSetting("youtube_url"));
            $form->get('twitter_url')->setData($services->getSetting("twitter_url"));
            $form->get('app_layout')->setData($services->getSetting("app_layout"));
            $form->get('app_theme')->setData($services->getSetting("app_theme"));
            $form->get('primary_color')->setData($services->getSetting("primary_color"));
            $form->get('no_reply_email')->setData($services->getSetting("no_reply_email"));
            $form->get('custom_css')->setData($services->getSetting("custom_css"));
            $form->get('google_analytics_code')->setData($services->getSetting("google_analytics_code"));
            $form->get('show_back_to_top_button')->setData($services->getSetting("show_back_to_top_button"));
            $form->get('show_terms_of_service_page')->setData($services->getSetting("show_terms_of_service_page"));
            $form->get('terms_of_service_page_slug')->setData($services->getSetting("terms_of_service_page_slug"));
            $form->get('show_privacy_policy_page')->setData($services->getSetting("show_privacy_policy_page"));
            $form->get('privacy_policy_page_slug')->setData($services->getSetting("privacy_policy_page_slug"));
            $form->get('show_cookie_policy_page')->setData($services->getSetting("show_cookie_policy_page"));
            $form->get('cookie_policy_page_slug')->setData($services->getSetting("cookie_policy_page_slug"));
            $form->get('show_cookie_policy_bar')->setData($services->getSetting("show_cookie_policy_bar"));
            $form->get('show_gdpr_compliance_page')->setData($services->getSetting("show_gdpr_compliance_page"));
            $form->get('gdpr_compliance_page_slug')->setData($services->getSetting("gdpr_compliance_page_slug"));
        }

        return $this->render('Dashboard/Administrator/Settings/layout.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/events-list-page", name="settings_events_list_page", methods="GET|POST")
     */
    public function eventsListPage(Request $request, AppServices $services, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('events_per_page', TextType::class, [
                    'required' => true,
                    'label' => 'Number of events per page',
                    'attr' => ['class' => 'touchspin-integer']
                ])
                ->add('show_map_button', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show map button',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_calendar_button', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show calendar button',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_rss_feed_button', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show RSS feed button',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_category_filter', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show category filter',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_location_filter', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show location filter',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_date_filter', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show date filter',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_ticket_price_filter', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show ticket price filter',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_audience_filter', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show audience filter',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
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
                $services->setSetting("events_per_page", $settings['events_per_page']);
                $services->setSetting("show_map_button", $settings['show_map_button']);
                $services->setSetting("show_calendar_button", $settings['show_calendar_button']);
                $services->setSetting("show_rss_feed_button", $settings['show_rss_feed_button']);
                $services->setSetting("show_category_filter", $settings['show_category_filter']);
                $services->setSetting("show_location_filter", $settings['show_location_filter']);
                $services->setSetting("show_date_filter", $settings['show_date_filter']);
                $services->setSetting("show_ticket_price_filter", $settings['show_ticket_price_filter']);
                $services->setSetting("show_audience_filter", $settings['show_audience_filter']);
                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('events_per_page')->setData($services->getSetting("events_per_page"));
            $form->get('show_map_button')->setData($services->getSetting("show_map_button"));
            $form->get('show_calendar_button')->setData($services->getSetting("show_calendar_button"));
            $form->get('show_rss_feed_button')->setData($services->getSetting("show_rss_feed_button"));
            $form->get('show_category_filter')->setData($services->getSetting("show_category_filter"));
            $form->get('show_location_filter')->setData($services->getSetting("show_location_filter"));
            $form->get('show_date_filter')->setData($services->getSetting("show_date_filter"));
            $form->get('show_ticket_price_filter')->setData($services->getSetting("show_ticket_price_filter"));
            $form->get('show_audience_filter')->setData($services->getSetting("show_audience_filter"));
        }

        return $this->render('Dashboard/Administrator/Settings/events-list-page.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/venue-page", name="settings_venue_page", methods="GET|POST")
     */
    public function venuePage(Request $request, AppServices $services, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('venue_comments_enabled', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Enable comments',
                    //'choices' => ['No' => 'no', 'Native comments' => 'native', 'Facebook comments' => 'facebook', 'Disqus comments' => 'disqus'],
                    'choices' => ['No' => 'no', 'Facebook comments' => 'facebook', 'Disqus comments' => 'disqus'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('facebook_app_id', TextType::class, [
                    'required' => false,
                    'label' => 'Facebook app id',
                    'help' => 'Go to the documentation to get help about getting an app ID'
                ])
                ->add('disqus_subdomain', TextType::class, [
                    'required' => false,
                    'label' => 'Disqus subdomain',
                    'help' => 'Go to the documentation to get help about setting up Disqus'
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
                $services->setSetting("venue_comments_enabled", $settings['venue_comments_enabled']);
                $services->setSetting("facebook_app_id", $settings['facebook_app_id']);
                $services->setSetting("disqus_subdomain", $settings['disqus_subdomain']);
                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('venue_comments_enabled')->setData($services->getSetting("venue_comments_enabled"));
            $form->get('facebook_app_id')->setData($services->getSetting("facebook_app_id"));
            $form->get('disqus_subdomain')->setData($services->getSetting("disqus_subdomain"));
        }

        return $this->render('Dashboard/Administrator/Settings/venue.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/blog", name="settings_blog", methods="GET|POST")
     */
    public function blog(Request $request, AppServices $services, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('blog_posts_per_page', TextType::class, [
                    'required' => true,
                    'label' => 'Number of blog posts per page',
                    'attr' => ['class' => 'touchspin-integer']
                ])
                ->add('blog_comments_enabled', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Enable comments',
                    //'choices' => ['No' => 'no', 'Native comments' => 'native', 'Facebook comments' => 'facebook', 'Disqus comments' => 'disqus'],
                    'choices' => ['No' => 'no', 'Facebook comments' => 'facebook', 'Disqus comments' => 'disqus'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('facebook_app_id', TextType::class, [
                    'required' => false,
                    'label' => 'Facebook app id',
                    'help' => 'Go to the documentation to get help about getting an app ID'
                ])
                ->add('disqus_subdomain', TextType::class, [
                    'required' => false,
                    'label' => 'Disqus subdomain',
                    'help' => 'Go to the documentation to get help about setting up Disqus'
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
                $services->setSetting("blog_posts_per_page", $settings['blog_posts_per_page']);
                $services->setSetting("blog_comments_enabled", $settings['blog_comments_enabled']);
                $services->setSetting("facebook_app_id", $settings['facebook_app_id']);
                $services->setSetting("disqus_subdomain", $settings['disqus_subdomain']);
                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('blog_posts_per_page')->setData($services->getSetting("blog_posts_per_page"));
            $form->get('blog_comments_enabled')->setData($services->getSetting("blog_comments_enabled"));
            $form->get('facebook_app_id')->setData($services->getSetting("facebook_app_id"));
            $form->get('disqus_subdomain')->setData($services->getSetting("disqus_subdomain"));
        }

        return $this->render('Dashboard/Administrator/Settings/blog.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/mail-server", name="settings_mail_server", methods="GET|POST")
     */
    public function mailServer(Request $request, AppServices $services, TranslatorInterface $translator) {

        if ($services->getEnv("DEMO_MODE") == "1") {
            $this->addFlash('error', $translator->trans('This feature is disabled in demo mode', [], 'javascript'));
            return $this->redirectToRoute("dashboard_index");
        }

        $form = $this->createFormBuilder()
                ->add('mail_server_transport', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Transport',
                    'choices' => ['SMTP' => 'smtp', 'Gmail' => 'gmail', 'Sendmail' => 'sendmail'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('mail_server_host', TextType::class, [
                    'required' => true,
                    'label' => 'Host',
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('mail_server_port', TextType::class, [
                    'required' => false,
                    'label' => 'Port',
                ])
                ->add('mail_server_encryption', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Encryption',
                    'choices' => ['None' => null, 'SSL' => 'ssl', 'TSL' => 'tls'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                ])
                /* ->add('mail_server_auth_mode', ChoiceType::class, [
                  'required' => true,
                  'multiple' => false,
                  'expanded' => true,
                  'label' => 'Authentication mode',
                  'choices' => ['None' => null, 'Login' => 'login', 'Cram-md5' => 'cram-md5', 'Plain' => 'plain'],
                  'label_attr' => ['class' => 'radio-custom radio-inline'],
                  ]) */
                ->add('mail_server_username', TextType::class, [
                    'required' => false,
                    'label' => 'Username',
                ])
                ->add('mail_server_password', TextType::class, [
                    'required' => false,
                    'label' => 'Password',
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
                $services->setSetting("mail_server_transport", $settings['mail_server_transport']);
                $services->setSetting("mail_server_host", $settings['mail_server_host']);
                $services->setSetting("mail_server_port", $settings['mail_server_port']);
                $services->setSetting("mail_server_encryption", $settings['mail_server_encryption']);
                //$services->setSetting("mail_server_auth_mode", $settings['mail_server_auth_mode']);
                $services->setSetting("mail_server_username", $settings['mail_server_username']);
                $services->setSetting("mail_server_password", $settings['mail_server_password']);

                $dsnUrl = $settings['mail_server_transport'] . "://";
                if (strlen($settings['mail_server_username'])) {
                    $dsnUrl .= $settings['mail_server_username'];
                }
                if (strlen($settings['mail_server_password'])) {
                    $dsnUrl .= ":" . $settings['mail_server_password'];
                }
                if (strlen($settings['mail_server_host'])) {
                    $dsnUrl .= "@" . $settings['mail_server_host'];
                }
                if (strlen($settings['mail_server_port'])) {
                    $dsnUrl .= ":" . $settings['mail_server_port'];
                }
                if (strlen($settings['mail_server_encryption'])) {
                    $dsnUrl .= "/?encryption=" . $settings['mail_server_encryption'];
                }

                $services->updateEnv("MAILER_URL", $dsnUrl);

                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('mail_server_transport')->setData($services->getSetting("mail_server_transport"));
            $form->get('mail_server_host')->setData($services->getSetting("mail_server_host"));
            $form->get('mail_server_port')->setData($services->getSetting("mail_server_port"));
            $form->get('mail_server_encryption')->setData($services->getSetting("mail_server_encryption"));
            //$form->get('mail_server_auth_mode')->setData($services->getSetting("mail_server_auth_mode"));
            $form->get('mail_server_username')->setData($services->getSetting("mail_server_username"));
            $form->get('mail_server_password')->setData($services->getSetting("mail_server_password"));
        }

        return $this->render('Dashboard/Administrator/Settings/mail-server.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/google-recaptcha", name="settings_google_recaptcha", methods="GET|POST")
     */
    public function googleRecaptcha(Request $request, AppServices $services, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('google_recaptcha_enabled', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Enable Google Repatcha',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('google_recaptcha_site_key', TextType::class, [
                    'required' => false,
                    'label' => 'Site key',
                ])
                ->add('google_recaptcha_secret_key', TextType::class, [
                    'required' => false,
                    'label' => 'Secret key',
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
                $services->setSetting("google_recaptcha_enabled", $settings['google_recaptcha_enabled']);
                $services->setSetting("google_recaptcha_site_key", $settings['google_recaptcha_site_key']);
                $services->setSetting("google_recaptcha_secret_key", $settings['google_recaptcha_secret_key']);

                $services->updateEnv("EWZ_RECAPTCHA_SITE_KEY", $settings['google_recaptcha_site_key']);
                $services->updateEnv("EWZ_RECAPTCHA_SECRET", $settings['google_recaptcha_secret_key']);

                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('google_recaptcha_enabled')->setData($services->getSetting("google_recaptcha_enabled"));
            $form->get('google_recaptcha_site_key')->setData($services->getSetting("google_recaptcha_site_key"));
            $form->get('google_recaptcha_secret_key')->setData($services->getSetting("google_recaptcha_secret_key"));
        }

        return $this->render('Dashboard/Administrator/Settings/google-recaptcha.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/google-maps", name="settings_google_maps", methods="GET|POST")
     */
    public function googleMaps(Request $request, AppServices $services, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('google_maps_api_key', TextType::class, [
                    'required' => false,
                    'label' => 'Google Maps Api Key',
                    'help' => 'Leave api key empty to disable google maps project wide'
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
                $services->updateEnv("GOOGLE_MAPS_API_KEY", $settings['google_maps_api_key']);

                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('google_maps_api_key')->setData($services->getEnv("GOOGLE_MAPS_API_KEY"));
        }

        return $this->render('Dashboard/Administrator/Settings/google-maps.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/social-login", name="settings_social_login", methods="GET|POST")
     */
    public function socialLogin(Request $request, AppServices $services, TranslatorInterface $translator) {

        $form = $this->createFormBuilder()
                ->add('social_login_facebook_enabled', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Enable Facebook Social Login',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('social_login_facebook_id', TextType::class, [
                    'required' => false,
                    'label' => 'Facebook Id',
                ])
                ->add('social_login_facebook_secret', TextType::class, [
                    'required' => false,
                    'label' => 'Facebook Secret',
                ])
                ->add('social_login_google_enabled', ChoiceType::class, [
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Enable Google Social Login',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('social_login_google_id', TextType::class, [
                    'required' => false,
                    'label' => 'Google Id',
                ])
                ->add('social_login_google_secret', TextType::class, [
                    'required' => false,
                    'label' => 'Google Secret',
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
                $services->setSetting("social_login_facebook_enabled", $settings['social_login_facebook_enabled']);
                $services->setSetting("social_login_facebook_id", $settings['social_login_facebook_id']);
                $services->setSetting("social_login_facebook_secret", $settings['social_login_facebook_secret']);
                $services->setSetting("social_login_google_enabled", $settings['social_login_google_enabled']);
                $services->setSetting("social_login_google_id", $settings['social_login_google_id']);
                $services->setSetting("social_login_google_secret", $settings['social_login_google_secret']);

                $services->updateEnv("FB_ID", $settings['social_login_facebook_id']);
                $services->updateEnv("FB_SECRET", $settings['social_login_facebook_secret']);
                $services->updateEnv("GOOGLE_ID", $settings['social_login_google_id']);
                $services->updateEnv("GOOGLE_SECRET", $settings['social_login_google_secret']);

                $this->addFlash('success', $translator->trans('The settings have been updated'));
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        } else {
            $form->get('social_login_facebook_enabled')->setData($services->getSetting("social_login_facebook_enabled"));
            $form->get('social_login_facebook_id')->setData($services->getSetting("social_login_facebook_id"));
            $form->get('social_login_facebook_secret')->setData($services->getSetting("social_login_facebook_secret"));
            $form->get('social_login_google_enabled')->setData($services->getSetting("social_login_google_enabled"));
            $form->get('social_login_google_id')->setData($services->getSetting("social_login_google_id"));
            $form->get('social_login_google_secret')->setData($services->getSetting("social_login_google_secret"));
        }

        return $this->render('Dashboard/Administrator/Settings/social-login.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/settings/menus", name="settings_menus", methods="GET")
     */
    public function menus(Request $request, AppServices $services, TranslatorInterface $translator) {

        $menus = $services->getMenus(array())->getQuery()->getResult();

        return $this->render('Dashboard/Administrator/Settings/menus.html.twig', [
                    'menus' => $menus
        ]);
    }

    /**
     * @Route("/settings/menus/{slug}/edit", name="settings_menus_edit", methods="GET|POST")
     */
    public function menuEdit(Request $request, AppServices $services, TranslatorInterface $translator, $slug) {

        $em = $this->getDoctrine()->getManager();

        $menu = $services->getMenus(array("slug" => $slug))->getQuery()->getOneOrNullResult();

        if (!$menu) {
            $this->addFlash('error', $translator->trans('The menu can not be found'));
            return $this->redirectToRoute('dashboard_administrator_settings_menus');
        }

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                foreach ($menu->getMenuElements() as $menuElement) {
                    $menuElement->setMenu($menu);
                }
                $em->persist($menu);
                $em->flush();
                $this->addFlash('success', $translator->trans('The menu has been successfully updated'));
                return $this->redirectToRoute('dashboard_administrator_settings_menus');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }

        return $this->render('Dashboard/Administrator/Settings/menu-edit.html.twig', [
                    'menu' => $menu,
                    'form' => $form->createView()
        ]);
    }

}
