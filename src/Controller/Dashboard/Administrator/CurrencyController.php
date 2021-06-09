<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\AppServices;
use App\Entity\Currency;
use App\Form\CurrencyType;
use Symfony\Contracts\Translation\TranslatorInterface;

class CurrencyController extends Controller {

    /**
     * @Route("/settings/payment/manage-currencies", name="currency", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {

        $ccy = ($request->query->get('ccy')) == "" ? "all" : $request->query->get('ccy');
        $symbol = ($request->query->get('symbol')) == "" ? "all" : $request->query->get('symbol');

        $currencies = $paginator->paginate($services->getCurrencies(array('ccy' => $ccy, 'symbol' => $symbol)), $request->query->getInt('page', 1), 20, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/Currency/index.html.twig', [
                    'currencies' => $currencies,
        ]);
    }

    /**
     * @Route("/settings/payment/manage-currencies/add", name="currency_add", methods="GET|POST")
     * @Route("/settings/payment/manage-currencies/{ccy}/edit", name="currency_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $ccy = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$ccy) {
            $currency = new Currency();
        } else {
            $currency = $services->getCurrencies(array('ccy' => $ccy))->getQuery()->getOneOrNullResult();
            if (!$currency) {
                $this->addFlash('error', $translator->trans('The currency can not be found'));
                return $services->redirectToReferer('currency');
            }
        }

        $form = $this->createForm(CurrencyType::class, $currency);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($currency);
                $em->flush();
                if (!$ccy) {
                    $this->addFlash('success', $translator->trans('The currency has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The currency has been successfully updated'));
                }
                return $this->redirectToRoute('dashboard_administrator_currency');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/Currency/add-edit.html.twig', array(
                    "currency" => $currency,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/settings/payment/manage-currencies/{ccy}/delete", name="currency_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $ccy) {

        $currency = $services->getCurrencies(array('ccy' => $ccy))->getQuery()->getOneOrNullResult();
        if (!$currency) {
            $this->addFlash('error', $translator->trans('The currency can not be found'));
            return $services->redirectToReferer('currency');
        }
        $this->addFlash('error', $translator->trans('The currency has been deleted'));
        $em = $this->getDoctrine()->getManager();
        $em->remove($currency);
        $em->flush();
        return $services->redirectToReferer('currency');
    }

}
