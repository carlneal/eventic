<?php

namespace App\Controller\Dashboard\PointOfSale;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller {

    /**
     * @Route(name="index")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $services->emptyCart($this->getUser());
        $events = $paginator->paginate($services->getEvents(array("onsalebypos" => $this->getUser()->getPointofsale()))->getQuery(), $request->query->getInt('page', 1), 12, array('wrap-queries' => true));
        return $this->render('Dashboard/PointOfSale/index.html.twig', [
                    "events" => $events
        ]);
    }

}
