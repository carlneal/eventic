<?php

namespace App\Controller\Dashboard\Main;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MainController extends Controller {

    /**
     * @Route("/", name="index")
     */
    public function index(AuthorizationCheckerInterface $authChecker) {
        if ($authChecker->isGranted('ROLE_ADMINISTRATOR')) {
            return $this->redirectToRoute("dashboard_administrator_index");
        } elseif ($authChecker->isGranted('ROLE_ORGANIZER')) {
            return $this->redirectToRoute("dashboard_organizer_index");
        } elseif ($authChecker->isGranted('ROLE_ATTENDEE')) {
            return $this->redirectToRoute("dashboard_attendee_index");
        } elseif ($authChecker->isGranted('ROLE_SCANNER')) {
            return $this->redirectToRoute("dashboard_scanner_index");
        } elseif ($authChecker->isGranted('ROLE_POINTOFSALE')) {
            return $this->redirectToRoute("dashboard_pointofsale_index");
        }
        return $this->redirectToRoute("fos_user_security_login");
    }

}
