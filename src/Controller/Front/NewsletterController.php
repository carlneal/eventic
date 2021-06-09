<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Welp\MailchimpBundle\Event\SubscriberEvent;
use Welp\MailchimpBundle\Subscriber\Subscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class NewsletterController extends AbstractController {

    /**
     * @Route("/newsletter-subscribe", name="newsletter_subscribe")
     */
    public function subscribe(Request $request, EventDispatcherInterface $eventdispatcher, TranslatorInterface $translator) {

        $subscriber = new Subscriber($request->request->get('email'), [], [
            'language' => $request->getLocale()
        ]);

        try {
            $eventdispatcher->dispatch(
                    SubscriberEvent::EVENT_SUBSCRIBE, new SubscriberEvent("b6909a170e", $subscriber)
            );
        } catch (Exception $e) {
            return new JsonResponse(['error' => $translator->trans('An error has occured')]);
        }
        return new JsonResponse(['success' => $translator->trans('You have successfully subscribed to our newsletter')]);
    }

}
