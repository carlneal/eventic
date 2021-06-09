<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     */
    public function homepage() {

        $herosettings = $this->getDoctrine()->getManager()->getRepository("App\Entity\HomepageHeroSettings")->find(1);

        return $this->render('Front/Main/homepage.html.twig', [
                    'herosettings' => $herosettings
        ]);
    }

}
