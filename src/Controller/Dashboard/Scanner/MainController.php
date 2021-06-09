<?php

namespace App\Controller\Dashboard\Scanner;

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
        $events = $paginator->paginate($services->getEvents(array("canbescannedby" => $this->getUser()->getScanner()))->getQuery(), $request->query->getInt('page', 1), 12, array('wrap-queries' => true));
        return $this->render('Dashboard/Scanner/index.html.twig', [
                    "events" => $events
        ]);
    }

}
