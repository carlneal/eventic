<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends Controller {

    /**
     * @Route("/translation", name="translation", methods="GET")
     */
    public function index() {
        return $this->render('Dashboard/Administrator/Translation/index.html.twig');
    }

}
