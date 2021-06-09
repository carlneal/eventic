<?php

namespace App\Controller\Dashboard\Attendee;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller {

    /**
     * @Route(name="index")
     */
    public function index() {
        return $this->redirectToRoute("dashboard_attendee_orders");
    }

}
