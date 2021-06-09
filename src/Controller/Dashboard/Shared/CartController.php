<?php

namespace App\Controller\Dashboard\Shared;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\AppServices;
use App\Entity\CartElement;

class CartController extends Controller {

    /**
     * @Route("/attendee/cart", name="dashboard_attendee_cart")
     */
    public function cart(Request $request, TranslatorInterface $translator, AppServices $services) {

        $em = $this->getDoctrine()->getManager();

        // Remove previous ticket reservations
        if (count($this->getUser()->getTicketreservations())) {
            foreach ($this->getUser()->getTicketreservations() as $ticketreservation) {
                $em->remove($ticketreservation);
            }
            $em->flush();
        }

        // Check event sale status
        foreach ($this->getUser()->getCartelements() as $cartelement) {
            if (!$cartelement->getEventticket()->isOnSale()) {
                $em->remove($cartelement);
                $em->flush();
                $this->addFlash('notice', $translator->trans('Your cart has been automatically updated because one or more events are no longer on sale'));
                return $this->redirectToRoute("dashboard_attendee_cart");
            }
            if (!$cartelement->getEventticket()->isOnSale()) {
                $em->remove($cartelement);
                $em->flush();
                $this->addFlash('notice', $translator->trans('Your cart has been automatically updated because one or more events are no longer on sale'));
                return $this->redirectToRoute("dashboard_attendee_cart");
            }
            if ($cartelement->getEventticket()->getTicketsLeftCount() > 0 && $cartelement->getQuantity() > $cartelement->getEventticket()->getTicketsLeftCount()) {
                $cartelement->setQuantity($cartelement->getEventticket()->getTicketsLeftCount());
                $em->persist($cartelement);
                $em->flush();
                $this->addFlash('notice', $translator->trans('Your cart has been automatically updated because one or more event\'s quotas has changed'));
                return $this->redirectToRoute("dashboard_attendee_cart");
            }
        }
        if ($request->getMethod() == "POST") {
            if (count($request->request->all()) == 0) {
                $this->addFlash('notice', $translator->trans('No tickets selected to add to cart'));
            } else {
                foreach ($request->request->all() as $ticketreference => $ticketquantity) {
                    $cartelement = $this->getUser()->getCartelementByEventTicketReference($ticketreference);
                    if (!$cartelement) {
                        $this->addFlash('error', $translator->trans('The event ticket can not be found'));
                        return $this->render('Dashboard/Attendee/Cart/cart.html.twig');
                    }
                    $cartelement->setQuantity($ticketquantity);
                    $em->persist($cartelement);
                }
                $em->flush();
                $this->addFlash('success', $translator->trans('Your cart has been updated'));
            }
        }

        return $this->render('Dashboard/Attendee/Cart/cart.html.twig');
    }

    /**
     * @Route("attendee/cart/add", name="dashboard_attendee_cart_add")
     * @Route("pointofsale/cart/add", name="dashboard_pointofsale_cart_add")
     */
    public function add(Request $request, TranslatorInterface $translator, AppServices $services) {

        $em = $this->getDoctrine()->getManager();

        foreach ($request->request->all() as $ticketreference => $ticketquantity) {
            if ($ticketquantity != "" && intval($ticketquantity) > 0) {
                $eventticket = $em->getRepository("App\Entity\EventTicket")->findOneByReference($ticketreference);
                if (!$eventticket) {
                    $this->addFlash('error', $translator->trans('The event ticket can not be found'));
                    return $services->redirectToReferer();
                }
                if (!$eventticket->isOnSale()) {
                    $this->addFlash('error', $eventticket->stringifyStatus());
                    return $services->redirectToReferer();
                }
                $cartelement = new CartElement();
                $cartelement->setUser($this->getUser());
                $cartelement->setEventticket($eventticket);
                $cartelement->setQuantity(intval($ticketquantity));

                if ($this->getUser()->hasRole("ROLE_ATTENDEE") && !$cartelement->getEventticket()->getFree()) {
                    $cartelement->setTicketFee($services->getSetting("ticket_fee_online"));
                } else if ($this->getUser()->hasRole("ROLE_POINTOFSALE") && !$cartelement->getEventticket()->getFree()) {
                    $cartelement->setTicketFee($services->getSetting("ticket_fee_pos"));
                }

                $em->persist($cartelement);
                $em->flush();
            }
        }
        if ($this->isGranted("ROLE_ATTENDEE")) {
            $this->addFlash('success', $translator->trans('The tickets has been successfully added to your cart'));
            return $this->redirectToRoute("dashboard_attendee_cart");
        } else {
            return $this->redirectToRoute("dashboard_pointofsale_checkout");
        }
    }

    /**
     * @Route("/attendee/cart/{id}/remove", name="dashboard_attendee_cart_remove")
     */
    public function remove($id, TranslatorInterface $translator, AppServices $services) {
        $em = $this->getDoctrine()->getManager();
        $cartelement = $em->getRepository("App\Entity\CartElement")->find($id);
        if ($cartelement->getUser() != $this->getUser()) {
            $this->addFlash('error', $translator->trans('Access is denied. You may not have the appropriate permissions to access this resource.'));
            return $this->redirectToRoute("dashboard_index");
        }
        $em->remove($cartelement);
        $em->flush();
        $this->addFlash('info', $translator->trans('Your cart has been updated'));
        return $services->redirectToReferer("cart");
    }

    /**
     * @Route("/attendee/cart/empty", name="dashboard_attendee_cart_empty")
     */
    public function emptyCart(TranslatorInterface $translator, AppServices $services) {
        $em = $this->getDoctrine()->getManager();
        $services->emptyCart($this->getUser());
        $this->addFlash('info', $translator->trans('Your cart has been emptied'));
        return $services->redirectToReferer("cart");
    }

}
