<?php

namespace App\Controller\Dashboard\Shared;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Form\CheckoutType;
use App\Service\AppServices;
use Payum\Core\Request\GetHumanStatus;
use Symfony\Component\Routing\RouterInterface;
use App\Entity\TicketReservation;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Asset\Packages;

class OrderController extends Controller {

    /**
     * @Route("/attendee/checkout", name="dashboard_attendee_checkout")
     * @Route("/pointofsale/checkout", name="dashboard_pointofsale_checkout")
     */
    public function checkout(Request $request, TranslatorInterface $translator, AppServices $services, RouterInterface $router) {

        if ($this->isGranted("ROLE_ATTENDEE")) {
            $paymentGateways = $services->getPaymentGateways(array())->getQuery()->getResult();
            $form = $this->createForm(CheckoutType::class, null, array('validation_groups' => 'attendee'));
        } else {
            $form = $this->createForm(CheckoutType::class, null, array('validation_groups' => 'pos'));
        }

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $order = null;

        if ($form->isSubmitted()) {

            $order = $services->getOrders(array('status' => 0, 'reference' => $form->getData()['orderReference']))->getQuery()->getOneOrNullResult();

            if ($form->isValid()) {

// Recheck order
                if (!$order) {
                    $this->addFlash('error', $translator->trans('The order can not be found'));
                    return $this->redirectToRoute("dashboard_index");
                }

// Recheck order elements
                if (!count($order->getOrderelements())) {
                    $this->addFlash('error', $translator->trans('You order is empty'));
                    return $this->redirectToRoute("dashboard_index");
                }
                foreach ($order->getOrderelements() as $orderelement) {
// Check event sale status
                    if (!$orderelement->getEventticket()->isOnSale()) {
                        $services->handleFailedPayment($order->getReference(), $translator->trans('Your order has been automatically canceled because one or more events are no longer on sale'));
                        $this->addFlash('notice', $translator->trans('Your order has been automatically canceled because one or more events are no longer on sale'));
                        return $this->redirectToRoute("dashboard_index");
                    }
// Check event quotas
                    if ($orderelement->getEventticket()->getTicketsLeftCount() > 0 && $orderelement->getQuantity() > $orderelement->getEventticket()->getTicketsLeftCount()) {
                        $services->handleFailedPayment($order->getReference(), $translator->trans('Your order has been automatically canceled because one or more event\'s quotas has changed'));
                        $this->addFlash('notice', $translator->trans('Your order has been automatically canceled because one or more event\'s quotas has changed'));
                        return $this->redirectToRoute("dashboard_index");
                    }
// Check ticket reservations
                    foreach ($orderelement->getTicketsReservations() as $ticketReservation) {
                        if ($ticketReservation->isExpired()) {
                            $services->handleFailedPayment($order->getReference(), $translator->trans('Your order has been automatically canceled because your ticket reservations has been released'));
                            $this->addFlash('notice', $translator->trans('Your order has been automatically canceled because your ticket reservations has been released'));
                            return $this->redirectToRoute("dashboard_index");
                        }
                    }
                }

                $storage = $this->get('payum')->getStorage('App\Entity\Payment');

                $orderTotalAmount = $order->getOrderElementsPriceSum(true);

                if ($orderTotalAmount == 0) {
                    $paymentGateway = $em->getRepository("App\Entity\PaymentGateway")->findOneBySlug("free");
                    $gatewayFactoryName = "offline";
                } elseif ($this->isGranted("ROLE_ATTENDEE")) {
                    if (count($paymentGateways) == 0) {
                        $this->addFlash('error', $translator->trans('No payment gateways are currently enabled'));
                        return $this->redirectToRoute("dashboard_attendee_cart");
                    }
                    $gatewayFactoryName = $request->request->get('payment_gateway');
                    $paymentGateway = $services->getPaymentGateways(array('gatewayFactoryName' => $gatewayFactoryName))->getQuery()->getOneOrNullResult();
                } else {
                    $paymentGateway = $em->getRepository("App\Entity\PaymentGateway")->findOneBySlug("point-of-sale");
                    $gatewayFactoryName = "offline";
                }
                if (!$paymentGateway) {
                    $this->addFlash('error', $translator->trans('The payment gateway can not be found'));
                    return $this->redirectToRoute("dashboard_index");
                }

// Sets the choosen payment gateway
                $order->setPaymentGateway($paymentGateway);
                $em->persist($order);

// Sets the amount to be paid
                $orderamount = intval(bcmul($orderTotalAmount, 100));

                $payment = $storage->create();
                $payment->setOrder($order);
                $payment->setNumber($services->generateReference(20));
                $payment->setCurrencyCode($services->getSetting("currency_ccy"));
                $payment->setTotalAmount($orderamount); // 1.23 USD = 123
                $payment->setDescription($translator->trans("Payment of tickets purchased on %website_name%", array('%website_name%' => $services->getSetting("website_name"))));
                $payment->setClientId($this->getUser()->getId());
                if ($form->getData()['firstname'] != null && $form->getData()['firstname'] != "") {
                    $payment->setFirstname($form->getData()['firstname']);
                }
                if ($form->getData()['lastname'] != null && $form->getData()['lastname'] != "") {
                    $payment->setLastname($form->getData()['lastname']);
                }
                if ($this->isGranted("ROLE_ATTENDEE")) {
                    $payment->setClientEmail($form->getData()['email']);
                    $payment->setCountry($form->getData()['country']);
                    $payment->setState($form->getData()['state']);
                    $payment->setCity($form->getData()['city']);
                    $payment->setPostalcode($form->getData()['postalcode']);
                    $payment->setStreet($form->getData()['street']);
                    $payment->setStreet2($form->getData()['street2']);
                }

                $storage->update($payment);
                $order->setPayment($payment);
                $em->flush();

                if ($this->isGranted("ROLE_ATTENDEE")) {
                    $captureToken = $this->get('payum')->getTokenFactory()->createCaptureToken(
                            $gatewayFactoryName, $payment, 'dashboard_attendee_checkout_done'
                    );
                } else {
                    $captureToken = $this->get('payum')->getTokenFactory()->createCaptureToken(
                            $gatewayFactoryName, $payment, 'dashboard_pointofsale_checkout_done'
                    );
                }

                return $this->redirect($captureToken->getTargetUrl());
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));

                if ($this->isGranted("ROLE_ATTENDEE")) {
                    return $this->render('Dashboard/Attendee/Order/checkout.html.twig', [
                                'form' => $form->createView(),
                                'paymentGateways' => $paymentGateways,
                                'order' => $order
                    ]);
                } else {
                    return $this->render('Dashboard/PointOfSale/Order/checkout.html.twig', [
                                'form' => $form->createView(),
                                'order' => $order
                    ]);
                }
            }
        } else {
// Check referer
            $referer = $request->headers->get('referer');
            if (!\is_string($referer) || !$referer) {
                $this->addFlash('info', $translator->trans('You must review your cart before proceeding to checkout'));
                return $this->redirectToRoute("dashboard_index");
            }
            if ($this->isGranted("ROLE_ATTENDEE")) {
                if ($router->match(Request::create($referer)->getPathInfo())['_route'] != "dashboard_attendee_cart") {
                    $this->addFlash('info', $translator->trans('You must review your cart before proceeding to checkout'));
                    return $this->redirectToRoute("dashboard_index");
                }
            }

// Recheck cart status
            if (!count($this->getUser()->getCartelements())) {
                $this->addFlash('error', $translator->trans('Your cart is empty'));
                return $this->redirectToRoute("dashboard_index");
            }

// Check event sale status
            foreach ($this->getUser()->getCartelements() as $cartelement) {
                if (!$cartelement->getEventticket()->isOnSale()) {
                    $em->remove($cartelement);
                    $em->flush();
                    $this->addFlash('notice', $translator->trans('Your cart has been automatically updated because one or more events are no longer on sale'));
                    return $this->redirectToRoute("dashboard_index");
                }
                if ($cartelement->getEventticket()->getTicketsLeftCount() > 0 && $cartelement->getQuantity() > $cartelement->getEventticket()->getTicketsLeftCount()) {
                    $cartelement->setQuantity($cartelement->getEventticket()->getTicketsLeftCount());
                    $em->persist($cartelement);
                    $em->flush();
                    $this->addFlash('notice', $translator->trans('Your cart has been automatically updated because one or more event\'s quotas has changed'));
                    return $this->redirectToRoute("dashboard_index");
                }
            }

// Remove previous ticket reservations
            if (count($this->getUser()->getTicketreservations())) {
                foreach ($this->getUser()->getTicketreservations() as $ticketreservation) {
                    $em->remove($ticketreservation);
                }
                $em->flush();
            }

            $order = $services->transformCartIntoOrder($this->getUser());
            if (!$order) {
                $this->addFlash('error', $translator->trans('The order can not be found'));
                return $this->redirectToRoute("dashboard_index");
            }
            $em->persist($order);
            $em->flush();
            $services->emptyCart($this->getUser());

// Create new ticket reservations according to current cart
            foreach ($order->getOrderelements() as $orderElement) {
                $ticketreservation = new TicketReservation();
                $ticketreservation->setEventticket($orderElement->getEventticket());
                $ticketreservation->setUser($this->getUser());
                $ticketreservation->setOrderelement($orderElement);
                $ticketreservation->setQuantity($orderElement->getQuantity());
                $expiresAt = new \DateTime;
                $ticketreservation->setExpiresAt($expiresAt->add(new \DateInterval('PT' . $services->getSetting("checkout_timeleft") . 'S')));
                $orderElement->addTicketsReservation($ticketreservation);
                $em->persist($ticketreservation);
                $em->flush();
            }
        }

        if ($this->isGranted("ROLE_ATTENDEE")) {
            return $this->render('Dashboard/Attendee/Order/checkout.html.twig', [
                        'form' => $form->createView(),
                        'paymentGateways' => $paymentGateways,
                        'order' => $order
            ]);
        } else {
            return $this->render('Dashboard/PointOfSale/Order/checkout.html.twig', [
                        'form' => $form->createView(),
                        'order' => $order
            ]);
        }
    }

    /**
     * @Route("/attendee/checkout/done", name="dashboard_attendee_checkout_done")
     * @Route("/pointofsale/checkout/done", name="dashboard_pointofsale_checkout_done")
     */
    public function done(Request $request, AppServices $services, TranslatorInterface $translator) {

// Remove ticket reservations
        $em = $this->getDoctrine()->getManager();
        if (count($this->getUser()->getTicketreservations())) {
            foreach ($this->getUser()->getTicketreservations() as $ticketreservation) {
                $em->remove($ticketreservation);
            }
            $em->flush();
        }

        try {
            $token = $this->get('payum')->getHttpRequestVerifier()->verify($request);
            $gateway = $this->get('payum')->getGateway($token->getGatewayName());
        } catch (Exception $e) {
            $this->addFlash('error', $translator->trans('An error has occured while processing your request'));
            return $this->redirectToRoute("dashboard_index");
        }
        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();
        $this->get('payum')->getHttpRequestVerifier()->invalidate($token);

        if ($status->isCaptured() || $status->isAuthorized() || $status->isPending()) {
            $services->handleSuccessfulPayment($payment->getOrder()->getReference());
            if ($payment->getOrder()->getOrderElementsPriceSum() > 0) {
                $this->addFlash('success', $translator->trans('Your payment has been successfully processed'));
            } else {
                $this->addFlash('success', $translator->trans('Your registration has been successfully processed'));
            }
            if ($this->isGranted("ROLE_ATTENDEE")) {
                return $this->redirectToRoute("dashboard_attendee_order_details", ['reference' => $payment->getOrder()->getReference()]);
            } else {
                return $this->redirectToRoute("dashboard_pointofsale_order_details", ['reference' => $payment->getOrder()->getReference()]);
            }
        } elseif ($status->isFailed()) {
            $services->handleFailedPayment($payment->getOrder()->getReference());
            $this->addFlash('error', $translator->trans('Your payment could not be processed at this time'));
            if ($this->isGranted("ROLE_ATTENDEE")) {
                return $this->redirectToRoute("dashboard_attendee_checkout_failure", ["number" => $payment->getNumber()]);
            } else {
                return $this->redirectToRoute("dashboard_pointofsale_index");
            }
        } elseif ($status->isCanceled()) {
            $services->handleCanceledPayment($payment->getOrder()->getReference());
            $this->addFlash('error', $translator->trans('Your payment operation was canceled'));
            if ($this->isGranted("ROLE_ATTENDEE")) {
                return $this->redirectToRoute("dashboard_attendee_orders");
            } else {
                return $this->redirectToRoute("dashboard_pointofsale_index");
            }
        } else {
            return $this->redirectToRoute("dashboard_index");
        }
        if ($this->isGranted("ROLE_ATTENDEE")) {
            return $this->render('Dashboard/Attendee/Order/failure.html.twig', [
                        'status' => $status->getValue(),
                        'paymentdetails' => $payment->getDetails()
            ]);
        } else {
            return $this->redirectToRoute("dashboard_index");
        }
    }

    /**
     * @Route("/attendee/checkout/failure/{number}", name="dashboard_attendee_checkout_failure")
     */
    public function failure($number, Request $request, AppServices $services, TranslatorInterface $translator) {

        $referer = $request->headers->get('referer');
        if (!\is_string($referer) || !$referer || $referer != "dashboard_attendee_checkout_done") {
            return $this->redirectToRoute("dashboard_attendee_orders");
        }

        $payment = $services->getPayments(array("number" => $number))->getQuery()->getOneOrNullResult();
        if (!$payment) {
            $this->addFlash('error', $translator->trans('The payment can not be found'));
            return $this->redirectToRoute("dashboard_attendee_orders");
        }

        return $this->render('Dashboard/Attendee/Order/failure.html.twig', [
                    'paymentdetails' => $payment->getDetails()
        ]);
    }

    /**
     * @Route("/attendee/my-tickets", name="dashboard_attendee_orders")
     * @Route("/pointofsale/my-orders", name="dashboard_pointofsale_orders")
     * @Route("/organizer/manage-orders", name="dashboard_organizer_orders")
     * @Route("/administrator/manage-orders", name="dashboard_administrator_orders")
     */
    public function orders(Request $request, AppServices $services, PaginatorInterface $paginator, AuthorizationCheckerInterface $authChecker, TranslatorInterface $translator) {

//$upcomingtickets = ($request->query->get('upcomingtickets')) == "" ? 1 : intval($request->query->get('upcomingtickets'));
        $reference = ($request->query->get('reference')) == "" ? "all" : $request->query->get('reference');
        $event = ($request->query->get('event')) == "" ? "all" : $request->query->get('event');
        $eventdate = ($request->query->get('eventdate')) == "" ? "all" : $request->query->get('eventdate');
        $eventticket = ($request->query->get('eventticket')) == "" ? "all" : $request->query->get('eventticket');
        $user = ($request->query->get('user')) == "" ? "all" : $request->query->get('user');
        $organizer = ($request->query->get('organizer')) == "" ? "all" : $request->query->get('organizer');
        $datefrom = ($request->query->get('datefrom')) == "" ? "all" : $request->query->get('datefrom');
        $dateto = ($request->query->get('dateto')) == "" ? "all" : $request->query->get('dateto');
        $status = ($request->query->get('status')) == "" ? "all" : $request->query->get('status');
        $paymentgateway = ($request->query->get('paymentgateway')) == "" ? "all" : $request->query->get('paymentgateway');

        $authChecker->isGranted("ROLE_ATTENDEE") ? $status = 1 : $upcomingtickets = "all";

        $ordersQuery = $services->getOrders(array("reference" => $reference, "event" => $event, "eventdate" => $eventdate, "eventticket" => $eventticket, "user" => $user, "organizer" => $organizer, "datefrom" => $datefrom, "dateto" => $dateto, "status" => $status, "paymentgateway" => $paymentgateway))->getQuery();

// Export current orders query results into Excel / Csv
        if (($authChecker->isGranted("ROLE_ADMINISTRATOR") || $authChecker->isGranted("ROLE_ORGANIZER") || $authChecker->isGranted("ROLE_POINTOFSALE")) && (($request->query->get('excel') == "1" || $request->query->get('csv') == "1" || $request->query->get('pdf') == "1"))) {
            $orders = $ordersQuery->getResult();
            if (!count($orders)) {
                $this->addFlash('error', $translator->trans('No orders found to be included in the report'));
                return $services->redirectToReferer("orders");
            }
            if ($request->query->get('excel') == "1" || $request->query->get('csv') == "1") {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle($services->getSetting("website_name") . " " . $translator->trans("orders summary"));
                $fileName = $services->getSetting("website_name") . " " . $translator->trans("orders summary") . " " . date_format(new \Datetime, "Y-m-d H i") . ".xlsx";
                $temp_file = tempnam(sys_get_temp_dir(), $fileName);

                $sheet->setCellValue('A3', $translator->trans("Order reference"));
                $sheet->setCellValue('B3', $translator->trans("Order status"));
                $sheet->setCellValue('C3', $translator->trans("Order Date"));
                $sheet->setCellValue('D3', $translator->trans("Organizer / Event / Date / Ticket"));
                $sheet->setCellValue('E3', $translator->trans("First Name"));
                $sheet->setCellValue('F3', $translator->trans("Last Name"));
                $sheet->setCellValue('G3', $translator->trans("Email"));
                $sheet->setCellValue('H3', $translator->trans("Quantity"));
                $sheet->setCellValue('I3', $translator->trans("Amount") . "(" . $services->getSetting("currency_ccy") . ")");
                $sheet->setCellValue('J3', $translator->trans("Payment"));
                $sheet->setCellValue('K3', $translator->trans("Street"));
                $sheet->setCellValue('L3', $translator->trans("Street 2"));
                $sheet->setCellValue('M3', $translator->trans("City"));
                $sheet->setCellValue('N3', $translator->trans("State"));
                $sheet->setCellValue('O3', $translator->trans("Zip / Postal code"));
                $sheet->setCellValue('P3', $translator->trans("Country"));
                $sheet->setCellValue('Q3', $translator->trans("Attendee status"));

                $i = 5;
                $totalSales = 0;
                $totalAttendees = 0;

                foreach ($orders as $order) {
                    foreach ($order->getOrderelements() as $orderElement) {
                        if ($authChecker->isGranted("ROLE_ADMINISTRATOR") || ($authChecker->isGranted("ROLE_ORGANIZER") && $this->getUser()->getOrganizer() == $orderElement->getEventticket()->getEventdate()->getEvent()->getOrganizer()) || $this->isGranted("ROLE_POINTOFSALE")) {
                            if (($event == "all" || $event != "all" && $orderElement->getEventticket()->getEventdate()->getEvent()->getSlug())) {
                                if (($event == "all" || ($event != "all" && $event == $orderElement->getEventticket()->getEventdate()->getEvent()->getSlug())) && ($eventdate == "all" || ($eventdate != "all" && $eventdate == $orderElement->getEventticket()->getEventdate()->getReference())) && ($eventticket == "all" || ($eventticket != "all" && $eventticket == $orderElement->getEventticket()->getReference()))) {
                                    $sheet->setCellValue('A' . $i, $orderElement->getOrder()->getReference());
                                    $sheet->setCellValue('B' . $i, $orderElement->getOrder()->stringifyStatus());
                                    $sheet->setCellValue('C' . $i, date_format($orderElement->getOrder()->getCreatedAt(), $this->getParameter("date_format_simple")));
                                    $sheet->setCellValue('D' . $i, $orderElement->getEventticket()->getEventdate()->getEvent()->getOrganizer()->getName() . " > " . $orderElement->getEventticket()->getEventdate()->getEvent()->getName() . " > " . date_format($orderElement->getEventticket()->getEventdate()->getStartdate(), $this->getParameter("date_format_simple")) . " > " . $orderElement->getEventticket()->getName());
                                    $sheet->setCellValue('E' . $i, $orderElement->getOrder()->getPayment() ? $orderElement->getOrder()->getPayment()->getFirstname() : $orderElement->getOrder()->getUser()->getFirstname());
                                    $sheet->setCellValue('F' . $i, $orderElement->getOrder()->getPayment() ? $orderElement->getOrder()->getPayment()->getLastname() : $orderElement->getOrder()->getUser()->getFirstname());
                                    $sheet->setCellValue('G' . $i, $orderElement->getOrder()->getPayment() ? $orderElement->getOrder()->getPayment()->getClientEmail() : $orderElement->getOrder()->getUser()->getEmail());
                                    $sheet->setCellValue('H' . $i, $orderElement->getQuantity());
                                    $sheet->setCellValue('I' . $i, $orderElement->getPrice());
                                    $sheet->setCellValue('J' . $i, $orderElement->getOrder()->getPaymentgateway() ? $orderElement->getOrder()->getPaymentgateway()->getName() : "");
                                    $sheet->setCellValue('K' . $i, $orderElement->getOrder()->getPayment() ? $orderElement->getOrder()->getPayment()->getStreet() : $orderElement->getOrder()->getUser()->getStreet());
                                    $sheet->setCellValue('L' . $i, $orderElement->getOrder()->getPayment() ? $orderElement->getOrder()->getPayment()->getStreet2() : $orderElement->getOrder()->getUser()->getStreet2());
                                    $sheet->setCellValue('M' . $i, $orderElement->getOrder()->getPayment() ? $orderElement->getOrder()->getPayment()->getCity() : $orderElement->getOrder()->getUser()->getCity());
                                    $sheet->setCellValue('N' . $i, $orderElement->getOrder()->getPayment() ? $orderElement->getOrder()->getPayment()->getState() : $orderElement->getOrder()->getUser()->getState());
                                    $sheet->setCellValue('O' . $i, $orderElement->getOrder()->getPayment() ? $orderElement->getOrder()->getPayment()->getPostalcode() : $orderElement->getOrder()->getUser()->getPostalcode());
                                    $sheet->setCellValue('P' . $i, $orderElement->getOrder()->getPayment() ? $orderElement->getOrder()->getPayment()->getCountry() : ($orderElement->getOrder()->getUser()->getCountry() ? $orderElement->getOrder()->getUser()->getCountry()->getName() : ""));
                                    $sheet->setCellValue('Q' . $i, $order->getStatus() == 1 ? $orderElement->getScannedTicketsCount() . " / " . $orderElement->getQuantity() : "");
                                    if ($order->getStatus() == 1) {
                                        $totalSales += $orderElement->getPrice();
                                        $totalAttendees += $orderElement->getQuantity();
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
                }

                $sheet->setCellValue('A1', $translator->trans("Generation date") . ": " . date_format(new \Datetime, $this->getParameter("date_format_simple")));
                $sheet->setCellValue('B1', $translator->trans("Total sales") . ": " . $totalSales . " " . $services->getSetting("currency_ccy"));
                $sheet->setCellValue('C1', $translator->trans("Total orders") . ": " . count($orders));
                $sheet->setCellValue('D1', $translator->trans("Total attendees") . ": " . $totalAttendees);



                if ($request->query->get('excel') == "1") {
                    $writer = new Xlsx($spreadsheet);
                } elseif ($request->query->get('csv') == "1") {
                    $writer = new Csv($spreadsheet);
                }
                $writer->save($temp_file);
                return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
            } else if ($request->query->get('pdf') == "1") {
                if (!$request->query->get('event')) {
                    $this->addFlash('error', $translator->trans('You must choose an event in order to export the attendees list'));
                    return $services->redirectToReferer("orders");
                }
                if ($request->query->get('status') != "1") {
                    $this->addFlash('error', $translator->trans('You must set the status to paid in order to export the attendees list'));
                    return $services->redirectToReferer("orders");
                }
                $organizer = "all";
                if ($authChecker->isGranted('ROLE_ORGANIZER')) {
                    $organizer = $this->getUser()->getOrganizer()->getSlug();
                }
                $event = $services->getEvents(array("slug" => $request->query->get('event'), "published" => "all", "elapsed" => "all", "organizer" => $organizer))->getQuery()->getOneOrNullResult();
                if (!$event) {
                    $this->addFlash('error', $translator->trans('The event can not be found'));
                    return $services->redirectToReferer("orders");
                }
                $pdfOptions = new Options();
//$pdfOptions->set('defaultFont', 'Arial');
                $dompdf = new Dompdf($pdfOptions);
                $html = $this->renderView('Dashboard/Shared/Order/attendees-pdf.html.twig', [
                    'event' => $event,
                    'orders' => $orders
                ]);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream($event->getName() . ": " . $translator->trans("Attendees list"), [
                    "Attachment" => false
                ]);
            }
        }

        $ordersPagination = $paginator->paginate($ordersQuery, $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Shared/Order/orders.html.twig', [
                    'orders' => $ordersPagination,
        ]);
    }

    /**
     * @Route("/attendee/my-tickets/{reference}", name="dashboard_attendee_order_details")
     * @Route("/pointofsale/my-orders/{reference}", name="dashboard_pointofsale_order_details")
     * @Route("/organizer/recent-orders/{reference}", name="dashboard_organizer_order_details")
     * @Route("/administrator/manage-orders/{reference}", name="dashboard_administrator_order_details")
     */
    public function details($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $order = $services->getOrders(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();
        if (!$order) {
            $this->addFlash('error', $translator->trans('The order can not be found'));
            return $services->redirectToReferer('orders');
        }

        $status = null;

        if ($order->getStatus() == 1) {
            $gateway = $this->get('payum')->getGateway($order->getPaymentGateway()->getGatewayName());
            $gateway->execute($status = new GetHumanStatus($order->getPayment()));
        }

        return $this->render('Dashboard/Shared/Order/details.html.twig', [
                    'order' => $order,
                    'status' => $status
        ]);
    }

    /**
     * @Route("/administrator/manage-orders/{reference}/cancel", name="dashboard_administrator_order_cancel")
     */
    public function cancel($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $order = $services->getOrders(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();

        if (!$order) {
            $this->addFlash('error', $translator->trans('The order can not be found'));
            return $services->redirectToReferer('orders');
        }

        if ($order->getDeletedAt()) {
            $this->addFlash('error', $translator->trans('The order has been soft deleted, restore it before canceling it'));
            return $services->redirectToReferer('orders');
        }

        if ($order->getStatus() != 0 && $order->getStatus() != 1) {
            $this->addFlash('error', $translator->trans('The order status must be paid or awaiting payment'));
            return $services->redirectToReferer('orders');
        }

        $services->handleCanceledPayment($order->getReference(), $request->query->get('note'));

        $this->addFlash('error', $translator->trans('The order has been permanently canceled'));

        return $services->redirectToReferer('orders');
    }

    /**
     * @Route("/administrator/manage-orders/{reference}/delete", name="dashboard_administrator_order_delete")
     */
    public function delete($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $order = $services->getOrders(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();
        if (!$order) {
            $this->addFlash('error', $translator->trans('The order can not be found'));
            return $services->redirectToReferer('orders');
        }
        $em = $this->getDoctrine()->getManager();

        if ($order->getDeletedAt()) {
            $this->addFlash('error', $translator->trans('The order has been permanently deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The order has been deleted'));
        }

        if ($order->getPayment()) {
            $order->getPayment()->setOrder(null);
            $em->persist($order);
            $em->persist($order->getPayment());
            $em->flush();
        }

        $em->remove($order);
        $em->flush();

        if ($request->query->get('forceRedirect') == "1") {
            return $this->redirectToRoute("dashboard_administrator_orders");
        }

        return $services->redirectToReferer('orders');
    }

    /**
     * @Route("/administrator/manage-orders/{reference}/restore", name="dashboard_administrator_order_restore")
     */
    public function restore($reference, Request $request, TranslatorInterface $translator, AppServices $services) {

        $order = $services->getOrders(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();
        if (!$order) {
            $this->addFlash('error', $translator->trans('The order can not be found'));
            return $services->redirectToReferer('orders');
        }

        $order->setDeletedAt(null);
        foreach ($order->getOrderelements() as $orderelement) {
            $orderelement->setDeletedAt(null);
            foreach ($orderelement->getTickets() as $ticket) {
                $ticket->setDeletedAt(null);
            }
            foreach ($orderelement->getTicketsReservations() as $ticketReservation) {
                $ticketReservation->setDeletedAt(null);
            }
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();
        $this->addFlash('success', $translator->trans('The order has been succesfully restored'));

        return $services->redirectToReferer('orders');
    }

    /**
     * @Route("/print-tickets/{reference}", name="dashboard_tickets_print")
     */
    public function printTickets($reference, Request $request, TranslatorInterface $translator, AppServices $services, UrlHelper $urlHelper, Packages $assetsManager) {

        $order = $services->getOrders(array("reference" => $reference))->getQuery()->getOneOrNullResult();
        if (!$order) {
            $this->addFlash('error', $translator->trans('The order can not be found'));
            return $this->redirectToRoute("dashboard_attendee_orders");
        }

        if ($request->getLocale() == "ar") {
            return $this->redirectToRoute("dashboard_tickets_print", ["reference" => $reference, "_locale" => "en"]);
        }

        $eventDateTicketReference = $request->query->get('event', 'all');

        $pdfOptions = new Options();
//$pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('Dashboard/Shared/Order/ticket-pdf.html.twig', [
            'order' => $order,
            'eventDateTicketReference' => $eventDateTicketReference,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($order->getReference() . "-" . $translator->trans("tickets"), [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/organizer/recent-orders/{reference}/resend-confirmation-email", name="dashboard_organizer_order_resend_confirmation_email")
     * @Route("/administrator/manage-orders/{reference}/resend-confirmation-email", name="dashboard_administrator_order_resend_confirmation_email")
     */
    public function resendConfirmationEmail($reference, Request $request, TranslatorInterface $translator, AppServices $services) {
        $order = $services->getOrders(array("reference" => $reference, "status" => "all"))->getQuery()->getOneOrNullResult();
        if (!$order) {
            $this->addFlash('error', $translator->trans('The order can not be found'));
            return $services->redirectToReferer('orders');
        }
        $services->sendOrderConfirmationEmail($order, $request->query->get('email'));
        $this->addFlash('success', $translator->trans('The confirmation email has been resent to') . ' ' . $request->query->get('email'));
        return $services->redirectToReferer('orders');
    }

}
