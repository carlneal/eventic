<?php

namespace App\Controller\Dashboard\Shared;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\AppServices;
use App\Entity\PayoutRequest;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use Payum\Core\Security\CypherInterface;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;

class PayoutRequestController extends Controller {

    private $cypher;

    public function __construct(CypherInterface $cypher = null) {
        $this->cypher = $cypher;
    }

    /**
     * @Route("/organizer/my-payout-requests/add/{eventDateReference}", name="dashboard_organizer_event_date_request_payout")
     */
    public function payoutRequestAdd($eventDateReference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $organizerPayoutMethods = $services->getPaymentGateways(array("organizer" => $this->getUser()->getOrganizer()->getSlug()))->getQuery()->getResult();
        if (count($organizerPayoutMethods) == 0) {
            $this->addFlash('error', $translator->trans('Please set a payout method before submitting a payout request'));
            return $this->redirectToRoute("dashboard_organizer_settings_payouts");
        }

        $eventDate = $services->getEventDates(array("reference" => $eventDateReference, "organizer" => $this->getUser()->getOrganizer()->getSlug()))->getQuery()->getOneOrNullResult();
        if (!$eventDate) {
            $this->addFlash('error', $translator->trans('The event date can not be found'));
            return $services->redirectToReferer('event');
        }
        if ($eventDate->isFree()) {
            $this->addFlash('error', $translator->trans('A payout can not be requested on a free event date'));
            return $services->redirectToReferer('event');
        }
        if ($eventDate->getOrganizerPayoutAmount() <= 0) {
            $this->addFlash('error', $translator->trans('The organizer revenue from this event date is currently zero'));
            return $services->redirectToReferer('event');
        }
        if ($eventDate->payoutRequested()) {
            $this->addFlash('error', $translator->trans('A payout is already requested for this event date'));
            return $services->redirectToReferer('event');
        }

        if ($request->isMethod("POST")) {

            $payoutMethodSlug = $request->request->get("payout_method");
            $payoutMethod = $services->getPaymentGateways(array("organizer" => $this->getUser()->getOrganizer()->getSlug(), "slug" => $payoutMethodSlug))->getQuery()->getOneOrNullResult();
            if (!$payoutMethod) {
                $this->addFlash('error', $translator->trans('The payout method can not be found'));
                return $this->redirectToRoute("dashboard_organizer_settings_payouts");
            }
            $payoutRequest = new PayoutRequest();
            $payoutRequest->setOrganizer($this->getUser()->getOrganizer());
            $payoutRequest->setPaymentGateway($payoutMethod);
            $payoutRequest->setEventDate($eventDate);
            $payoutRequest->setStatus(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($payoutRequest);
            $em->flush();
            $this->addFlash('success', $translator->trans('The payout request has been successfully submitted, you will be notified by email once it is processed'));
            return $this->redirectToRoute("dashboard_organizer_payout_requests");
        } else {

            return $this->render('Dashboard/Shared/Payout/request.html.twig', [
                        'eventDate' => $eventDate,
                        'organizerPayoutMethods' => $organizerPayoutMethods
            ]);
        }
    }

    /**
     * @Route("/administrator/manage-payout-requests", name="dashboard_administrator_payout_requests")
     * @Route("/organizer/my-payout-requests", name="dashboard_organizer_payout_requests")
     */
    public function payoutRequests(Request $request, AppServices $services, PaginatorInterface $paginator) {

        $reference = ($request->query->get('reference')) == "" ? "all" : $request->query->get('reference');
        $eventdate = ($request->query->get('eventdate')) == "" ? "all" : $request->query->get('eventdate');
        $organizer = ($request->query->get('organizer')) == "" ? "all" : $request->query->get('organizer');
        $datefrom = ($request->query->get('datefrom')) == "" ? "all" : $request->query->get('datefrom');
        $dateto = ($request->query->get('dateto')) == "" ? "all" : $request->query->get('dateto');
        $status = ($request->query->get('status')) == "" ? "all" : $request->query->get('status');

        $payoutRequests = $paginator->paginate($services->getPayoutRequests(array("reference" => $reference, "eventdate" => $eventdate, "organizer" => $organizer, "datefrom" => $datefrom, "dateto" => $dateto, "status" => $status))->getQuery(), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Shared/Payout/requests.html.twig', [
                    "payoutRequests" => $payoutRequests
        ]);
    }

    /**
     * @Route("/administrator/manage-payout-requests/{reference}/cancel", name="dashboard_administrator_payout_request_cancel")
     * @Route("/organizer/my-payout-requests/{reference}/cancel", name="dashboard_organizer_payout_request_cancel")
     */
    public function cancel($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $payoutRequest = $services->getPayoutRequests(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();

        if (!$payoutRequest) {
            $this->addFlash('error', $translator->trans('The payout request can not be found'));
            return $services->redirectToReferer('payout_requests');
        }

        if ($payoutRequest->getDeletedAt()) {
            $this->addFlash('error', $translator->trans('The payout request has been soft deleted, restore it before canceling it'));
            return $services->redirectToReferer('payout_requests');
        }

        if ($payoutRequest->getStatus() != 0) {
            $this->addFlash('error', $translator->trans('The payout request can not be canceled because it is already processed'));
            return $services->redirectToReferer('payout_requests');
        }

        $em = $this->getDoctrine()->getManager();
        $payoutRequest->setStatus(-1);
        if ($request->query->get("note")) {
            $payoutRequest->setNote($request->query->get("note"));
        }
        $em->persist($payoutRequest);
        $em->flush();
        if ($this->isGranted("ROLE_ADMINISTRATOR")) {
            $services->sendPayoutProcessedEmail($payoutRequest, $payoutRequest->getOrganizer()->getUser()->getEmail());
        }
        $this->addFlash('error', $translator->trans('The payout request has been permanently canceled'));

        return $services->redirectToReferer('payout_requests');
    }

    /**
     * @Route("/administrator/manage-payout-requests/{reference}/failed", name="dashboard_administrator_payout_request_failed")
     */
    public function failed($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $payoutRequest = $services->getPayoutRequests(array("reference" => $reference, "status" => 0))->getQuery()->getOneOrNullResult();

        if (!$payoutRequest) {
            $this->addFlash('error', $translator->trans('The payout request can not be found'));
            return $services->redirectToReferer('payout_requests');
        }

        if ($payoutRequest->getDeletedAt()) {
            $this->addFlash('error', $translator->trans('The payout request has been soft deleted, restore it before canceling it'));
            return $services->redirectToReferer('payout_requests');
        }

        if ($payoutRequest->getStatus() != 0) {
            $this->addFlash('error', $translator->trans('The payout request can not be canceled because it is already processed'));
            return $services->redirectToReferer('payout_requests');
        }

        $em = $this->getDoctrine()->getManager();
        $payoutRequest->setStatus(-2);
        $em->persist($payoutRequest);
        $em->flush();
        $services->sendPayoutProcessedEmail($payoutRequest, $payoutRequest->getOrganizer()->getUser()->getEmail());
        $this->addFlash('error', $translator->trans('The payout request can not be processed at this moment'));

        return $services->redirectToReferer('payout_requests');
    }

    /**
     * @Route("/administrator/manage-payout-requests/{reference}/delete", name="dashboard_administrator_payout_request_delete")
     */
    public function delete($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $payoutRequest = $services->getPayoutRequests(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();
        if (!$payoutRequest) {
            $this->addFlash('error', $translator->trans('The payout request can not be found'));
            return $services->redirectToReferer('payout_requests');
        }
        $em = $this->getDoctrine()->getManager();

        if ($payoutRequest->getDeletedAt()) {
            $this->addFlash('error', $translator->trans('The payout request has been permanently deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The payout request has been deleted'));
        }
        //$services->sendPayoutProcessedEmail($payoutRequest, $payoutRequest->getOrganizer()->getUser()->getEmail());
        $payoutRequest->setStatus(-1);
        $payoutRequest->setNote($translator->trans("Automatically canceled before deletion"));
        $em->persist($payoutRequest);
        $em->flush();
        $em->remove($payoutRequest);
        $em->flush();

        if ($request->query->get('forceRedirect') == "1") {
            return $this->redirectToRoute("dashboard_administrator_payout_requests");
        }

        return $services->redirectToReferer('payout_requests');
    }

    /**
     * @Route("/administrator/manage-payout-requests/{reference}/restore", name="dashboard_administrator_payout_request_restore")
     */
    public function restore($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $payoutRequest = $services->getPayoutRequests(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();
        if (!$payoutRequest) {
            $this->addFlash('error', $translator->trans('The payout request can not be found'));
            return $services->redirectToReferer('payout_requests');
        }

        $payoutRequest->setDeletedAt(null);

        $em = $this->getDoctrine()->getManager();
        $em->persist($payoutRequest);
        $em->flush();
        $this->addFlash('success', $translator->trans('The payout request has been succesfully restored'));

        return $services->redirectToReferer('payout_requests');
    }

    /**
     * @Route("/administrator/manage-payout-requests/{reference}/approve", name="dashboard_administrator_payout_request_approve")
     */
    public function approve($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $em = $this->getDoctrine()->getManager();
        $payoutRequest = $services->getPayoutRequests(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();
        if (!$payoutRequest) {
            $this->addFlash('error', $translator->trans('The payout request can not be found'));
            return $services->redirectToReferer('payout_requests');
        }
        if ($payoutRequest->getStatus() != 0) {
            $this->addFlash('error', $translator->trans('The payout request has been already processed'));
            return $services->redirectToReferer('payout_requests');
        }

        $payoutRequest->getPaymentGateway()->decrypt($this->cypher);

        if ($payoutRequest->getPaymentGateway()->getFactoryName() == "paypal_rest") {

            $apiContext = new ApiContext(
                    new OAuthTokenCredential(
                    $payoutRequest->getPaymentGateway()->getConfig()['client_id'], $payoutRequest->getPaymentGateway()->getConfig()['client_secret']
                    )
            );

            $mode = "sandbox";
            if ($payoutRequest->getPaymentGateway()->getConfig()['sandbox'] == false) {
                $mode = "live";
            }
            $apiContext->getConfig(array(
                'log.LogEnabled' => false,
                'mode' => $mode
            ));

            $payer = new Payer();
            $payer->setPaymentMethod('Paypal');
            $amount = new Amount();

            $amount->setTotal($payoutRequest->getEventDate()->getOrganizerPayoutAmount());
            $amount->setCurrency($services->getSetting("currency_ccy"));

            $transaction = new Transaction();
            $transaction->setAmount($amount);

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($this->generateUrl("dashboard_administrator_payout_request_approved", ["reference" => $payoutRequest->getReference()], UrlGeneratorInterface::ABSOLUTE_URL))
                    ->setCancelUrl($this->generateUrl("dashboard_administrator_payout_request_failed", ["reference" => $payoutRequest->getReference()], UrlGeneratorInterface::ABSOLUTE_URL));


            $payment = new Payment();
            $payment->setIntent("ORDER")
                    ->setPayer($payer)
                    ->setTransactions(array($transaction))
                    ->setRedirectUrls($redirectUrls);

            try {
                $payment->create($apiContext);
                $payoutRequest->setPayment($payment->toArray());
                $em->persist($payoutRequest);
                $em->flush();
                return $this->redirect($payment->getApprovalLink());
            } catch (PayPalConnectionException $ex) {
                $this->addFlash('error', $translator->trans('An error has occured while processing your request'));
                $this->redirectToRoute("dashboard_administrator_payout_requests");
            }
        } else if ($payoutRequest->getPaymentGateway()->getFactoryName() == "stripe_checkout") {

            if ($request->isMethod("POST")) {

                \Stripe\Stripe::setApiKey($payoutRequest->getPaymentGateway()->getConfig()['secret_key']);

                $token = $request->request->get('stripeToken');

                $stripePaymentError = false;

                try {
                    $charge = \Stripe\Charge::create([
                                'amount' => number_format($payoutRequest->getEventDate()->getOrganizerPayoutAmount(), 2, '', ''),
                                'currency' => $services->getSetting("currency_ccy"),
                                'description' => $translator->trans("Organizer revenue from %website_name%", ["%website_name%" => $services->getSetting("website_name")]),
                                'source' => $token,
                    ]);
                } catch (\Stripe\Error\Card $e) {
                    $this->addFlash('error', $translator->trans('An error has occured while processing your request') . ": " . $e->getMessage());
                    $stripePaymentError = true;
                } catch (\Stripe\Error\Api $e) {
                    $this->addFlash('error', $translator->trans('An error has occured while processing your request') . ": " . $e->getMessage());
                    $stripePaymentError = true;
                } catch (\Stripe\Error\ApiConnection $e) {
                    $this->addFlash('error', $translator->trans('An error has occured while processing your request') . ": " . $e->getMessage());
                    $stripePaymentError = true;
                } catch (\Stripe\Error\Authentication $e) {
                    $this->addFlash('error', $translator->trans('An error has occured while processing your request') . ": " . $e->getMessage());
                    $stripePaymentError = true;
                } catch (\Stripe\Error\Base $e) {
                    $this->addFlash('error', $translator->trans('An error has occured while processing your request') . ": " . $e->getMessage());
                    $stripePaymentError = true;
                } catch (\Stripe\Error\InvalidRequest $e) {
                    $this->addFlash('error', $translator->trans('An error has occured while processing your request') . ": " . $e->getMessage());
                    $stripePaymentError = true;
                } catch (\Stripe\Error\Permission $e) {
                    $this->addFlash('error', $translator->trans('An error has occured while processing your request') . ": " . $e->getMessage());
                    $stripePaymentError = true;
                } catch (\Stripe\Error\RateLimit $e) {
                    $this->addFlash('error', $translator->trans('An error has occured while processing your request') . ": " . $e->getMessage());
                    $stripePaymentError = true;
                } catch (Exception $e) {
                    $this->addFlash('error', $translator->trans('An error has occured while processing your request'));
                    $stripePaymentError = true;
                }

                if ($stripePaymentError) {
                    return $this->redirectToRoute("dashboard_administrator_payout_requests");
                }

                $payoutRequest->setPayment(json_decode($charge->getLastResponse()->body, true));
                $em->persist($payoutRequest);
                $em->flush();

                if ($charge->getLastResponse()->code == 200) {
                    $payoutRequest->setStatus(1);
                    $em->persist($payoutRequest);
                    $em->flush();
                    $services->sendPayoutProcessedEmail($payoutRequest, $payoutRequest->getOrganizer()->getUser()->getEmail());
                    $this->addFlash('success', $translator->trans('The payout request has been successfully processed'));
                } else {
                    return $this->redirectToRoute("dashboard_administrator_payout_request_failed", ["reference" => $payoutRequest->getReference()]);
                }
            } else {
                return $this->render('Dashboard/Shared/Payout/stripe.html.twig', [
                            "stripePublishableKey" => $payoutRequest->getPaymentGateway()->getConfig()['publishable_key']
                ]);
            }
        }

        return $this->redirectToRoute("dashboard_administrator_payout_requests");
    }

    /**
     * @Route("/administrator/manage-payout-requests/{reference}/approved", name="dashboard_administrator_payout_request_approved")
     */
    public function approved($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $payoutRequest = $services->getPayoutRequests(array("reference" => $reference, "status" => 0))->getQuery()->getOneOrNullResult();

        if (!$payoutRequest) {
            $this->addFlash('error', $translator->trans('The payout request can not be found'));
            return $this->redirectToRoute("dashboard_administrator_payout_requests");
        }

        if ($payoutRequest->getDeletedAt()) {
            $this->addFlash('error', $translator->trans('The payout request has been soft deleted, restore it before canceling it'));
            return $this->redirectToRoute("dashboard_administrator_payout_requests");
        }

        if ($payoutRequest->getStatus() != 0) {
            $this->addFlash('error', $translator->trans('The payout request can not be canceled because it is already processed'));
            return $this->redirectToRoute("dashboard_administrator_payout_requests");
        }

        if ($payoutRequest->getPayment() == null) {
            $this->addFlash('error', $translator->trans('The payout request can not be processed at this moment'));
            return $this->redirectToRoute("dashboard_administrator_payout_requests");
        }

        if ($payoutRequest->getPaymentGateway()->getFactoryName() == "paypal_rest") {

            if (!$request->query->has("paymentId") || !$request->query->has("token") || !$request->query->has("PayerID")) {
                $this->addFlash('error', $translator->trans('The payout request can not be processed at this moment'));
                return $this->redirectToRoute("dashboard_administrator_payout_requests");
            }

            $payment = new Payment();
            $payment->fromArray($payoutRequest->getPayment());

            $paymentExecution = new PaymentExecution();
            $paymentExecution->setPayerId($request->query->get("PayerID"));

            $transaction = $payment->getTransactions()[0];
            $paymentExecution->addTransaction($transaction);

            $payoutRequest->getPaymentGateway()->decrypt($this->cypher);
            $apiContext = new ApiContext(
                    new OAuthTokenCredential(
                    $payoutRequest->getPaymentGateway()->getConfig()['client_id'], $payoutRequest->getPaymentGateway()->getConfig()['client_secret']
                    )
            );

            $mode = "sandbox";
            if ($payoutRequest->getPaymentGateway()->getConfig()['sandbox'] == false) {
                $mode = "live";
            }
            $apiContext->getConfig(array(
                'log.LogEnabled' => false,
                'mode' => $mode
            ));

            try {
                $succesfullTransactionDetails = $payment->execute($paymentExecution, $apiContext);
                $em = $this->getDoctrine()->getManager();
                $payoutRequest->setStatus(1);
                $payoutRequest->setPayment($succesfullTransactionDetails->toArray());
                $em->persist($payoutRequest);
                $em->flush();
                $services->sendPayoutProcessedEmail($payoutRequest, $payoutRequest->getOrganizer()->getUser()->getEmail());
                $this->addFlash('success', $translator->trans('The payout request has been successfully processed'));
            } catch (PayPalConnectionException $ex) {
                $this->addFlash('error', $translator->trans('An error has occured while processing your request'));
                $this->redirectToRoute("dashboard_administrator_payout_requests");
            }
        }

        return $services->redirectToReferer('payout_requests');
    }

    /**
     * @Route("/administrator/manage-payout-requests/{reference}/details", name="dashboard_administrator_payout_request_details")
     * @Route("/organizer/my-payout-requests/{reference}/details", name="dashboard_organizer_payout_request_details")
     */
    public function details($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $payoutRequest = $services->getPayoutRequests(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();

        if (!$payoutRequest) {
            $this->addFlash('error', $translator->trans('The payout request can not be found'));
            return $services->redirectToReferer('payout_requests');
        }

        return $this->render('Dashboard/Shared/Payout/details.html.twig', [
                    "payoutRequest" => $payoutRequest
        ]);
    }

}
