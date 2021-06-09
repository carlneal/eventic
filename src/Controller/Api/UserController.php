<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\AppServices;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

// Used in orders page

class UserController extends Controller {

    /**
     * @Route("/get-organizers", name="get_organizers")
     * @Route("/get-users", name="get_users")
     */
    public function getUsers(Request $request, AppServices $services): Response {

        if (!$this->isGranted("ROLE_ADMINISTRATOR") && !$this->isGranted("ROLE_ORGANIZER")) {
            throw new AccessDeniedHttpException();
        }

        $q = ($request->query->get('q')) == "" ? "all" : $request->query->get('q');
        $limit = ($request->query->get('limit')) == "" ? 10 : $request->query->get('limit');

        if ($request->get('_route') == "get_organizers") {
            $users = $services->getUsers(array('role' => 'organizer', 'organizername' => $q, 'limit' => $limit))->getQuery()->getResult();
        } else if ($request->get('_route') == "get_users") {
            if ($this->isGranted("ROLE_ORGANIZER")) {
                $attendees = $services->getUsers(array('keyword' => $q, 'role' => 'attendee', 'hasboughtticketfororganizer' => $this->getUser()->getOrganizer()->getSlug(), 'limit' => $limit))->getQuery()->getResult();
                $pointsofsale = $services->getUsers(array('keyword' => $q, 'role' => 'pointofsale', 'limit' => $limit))->getQuery()->getResult();
                $users = array_merge($attendees, $pointsofsale);
            } else {
                $attendees = $services->getUsers(array('keyword' => $q, 'role' => 'attendee', 'limit' => $limit))->getQuery()->getResult();
                $pointsofsale = $services->getUsers(array('keyword' => $q, 'role' => 'point_of_sale', 'limit' => $limit))->getQuery()->getResult();
                $users = array_merge($attendees, $pointsofsale);
            }
        }

        $results = array();
        foreach ($users as $user) {
            if ($request->get('_route') == "get_organizers") {
                $result = array('id' => $user->getOrganizer()->getSlug(), 'text' => $user->getOrganizer()->getName());
            } else if ($request->get('_route') == "get_users") {
                $result = array('id' => $user->getSlug(), 'text' => $user->getCrossRoleName());
            }
            array_push($results, $result);
        }

        return $this->json($results);
    }

    /**
     * @Route("/get-organizer/{slug}", name="get_organizer")
     * @Route("/get-user/{slug}", name="get_user")
     */
    public function getUserEntity(Request $request, $slug = null, AppServices $services): Response {

        if ($request->get('_route') == "get_organizer") {
            if (!$this->isGranted("ROLE_ADMINISTRATOR")) {
                throw new AccessDeniedHttpException();
            }
            $user = $services->getUsers(array('role' => 'organizer', 'organizerslug' => $slug))->getQuery()->getOneOrNullResult();
            return $this->json(array("slug" => $user->getOrganizer()->getSlug(), "text" => $user->getOrganizer()->getName()));
        } else if ($request->get('_route') == "get_user") {

            if (!$this->isGranted("ROLE_ADMINISTRATOR") && !$this->isGranted("ROLE_ORGANIZER")) {
                throw new AccessDeniedHttpException();
            }
            $hasboughtticketfororganizer = "all";
            if ($this->isGranted("ROLE_ORGANIZER")) {
                $hasboughtticketfororganizer = $this->getUser()->getOrganizer()->getSlug();
            }

            $user = $services->getUsers(array('role' => 'attendee', 'slug' => $slug, 'hasboughtticketfororganizer' => $hasboughtticketfororganizer))->getQuery()->getOneOrNullResult();

            if (!$user) {
                $user = $services->getUsers(array('role' => 'point_of_sale', 'slug' => $slug, 'createdbyorganizerslug' => $this->getUser()->getOrganizer()->getSlug()))->getQuery()->getOneOrNullResult();
            }

            return $this->json(array("slug" => $user->getSlug(), "text" => $user->getFullName()));
        }
    }

}
