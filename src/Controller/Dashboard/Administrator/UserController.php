<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserController extends Controller {

    /**
     * @Route("/manage-users", name="user", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {

        $role = ($request->query->get('role')) == "" ? "all" : $request->query->get('role');
        $createdbyorganizerslug = ($request->query->get('createdbyorganizerslug')) == "" ? "all" : $request->query->get('createdbyorganizerslug');
        $organizername = ($request->query->get('organizername')) == "" ? "all" : $request->query->get('organizername');
        $username = ($request->query->get('username')) == "" ? "all" : $request->query->get('username');
        $email = ($request->query->get('email')) == "" ? "all" : $request->query->get('email');
        $firstname = ($request->query->get('firstname')) == "" ? "all" : $request->query->get('firstname');
        $lastname = ($request->query->get('lastname')) == "" ? "all" : $request->query->get('lastname');
        $enabled = ($request->query->get('enabled')) == "" ? "all" : $request->query->get('enabled');
        $countryslug = ($request->query->get('countryslug')) == "" ? "all" : $request->query->get('countryslug');
        $users = $paginator->paginate($services->getUsers(array('role' => $role, 'createdbyorganizerslug' => $createdbyorganizerslug, 'organizername' => $organizername, 'username' => $username, 'email' => $email, 'firstname' => $firstname, 'lastname' => $lastname, 'enabled' => $enabled, 'countryslug' => $countryslug)), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/User/index.html.twig', [
                    'users' => $users
        ]);
    }

    /**
     * @Route("/manage-users/{slug}/delete-permanently", name="user_delete_permanently", methods="GET")
     * @Route("/manage-users/{slug}/delete", name="user_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $user = $services->getUsers(array('slug' => $slug, 'enabled' => 'all'))->getQuery()->getOneOrNullResult();
        if (!$user) {
            $this->addFlash('error', $translator->trans('The user can not be found'));
            return $services->redirectToReferer('user');
        }
        $em = $this->getDoctrine()->getManager();

        if ($user->getDeletedAt() !== null) {
            /* if ($user->getOrganizer()) {
              $user->getOrganizer()->setUser(null);
              $em->persist($user->getOrganizer());
              $em->flush();
              $user->setOrganizer(null);
              }
              if ($user->hasRole('ROLE_SCANNER')) {
              $user->getScanner()->setUser(null);
              $em->persist($user->getScanner());
              $em->flush();
              $user->setScanner(null);
              }
              if ($user->hasRole('ROLE_POINTOFSALE')) {
              $user->getPointofsale()->setUser(null);
              $em->persist($user->getPointofsale());
              $em->flush();
              $user->setPointofsale(null);
              } */
            $this->addFlash('error', $translator->trans('The user has been permanently deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The user has been deleted'));
        }
        $em->remove($user);
        $em->flush();
        return $services->redirectToReferer('user');
    }

    /**
     * @Route("/manage-users/{slug}/restore", name="user_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $user = $services->getUsers(array('slug' => $slug, 'enabled' => 'all'))->getQuery()->getOneOrNullResult();
        if (!$user) {
            $this->addFlash('error', $translator->trans('The user can not be found'));
            return $services->redirectToReferer('user');
        }
        $user->setDeletedAt(null);
        $user->getOrganizer()->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $this->addFlash('success', $translator->trans('The user has been succesfully restored'));

        return $services->redirectToReferer('user');
    }

    /**
     * @Route("/manage-users/{slug}/enable", name="user_enable", methods="GET")
     * @Route("/manage-users/{slug}/disable", name="user_disable", methods="GET")
     */
    public function enabledisable(AppServices $services, TranslatorInterface $translator, $slug) {

        $user = $services->getUsers(array('slug' => $slug, 'enabled' => 'all'))->getQuery()->getOneOrNullResult();
        if (!$user) {
            $this->addFlash('error', $translator->trans('The user can not be found'));
            return $services->redirectToReferer('page');
        }
        $em = $this->getDoctrine()->getManager();
        if ($user->isEnabled()) {
            $user->setEnabled(false);
            if ($user->hasRole("ROLE_ORGANIZER")) {
                foreach ($user->getOrganizer()->getScanners() as $scanner) {
                    $scanner->getUser()->setEnabled(false);
                    $em->persist($scanner->getUser());
                }
                foreach ($user->getOrganizer()->getPointofsales() as $pos) {
                    $pos->getUser()->setEnabled(false);
                    $em->persist($pos->getUser());
                }
            }
            $this->addFlash('notice', $translator->trans('The user has been disabled'));
        } else {
            $user->setEnabled(true);
            if ($user->hasRole("ROLE_ORGANIZER")) {
                foreach ($user->getOrganizer()->getScanners() as $scanner) {
                    $scanner->getUser()->setEnabled(true);
                    $em->persist($scanner->getUser());
                }
                foreach ($user->getOrganizer()->getPointofsales() as $pos) {
                    $pos->getUser()->setEnabled(true);
                    $em->persist($pos->getUser());
                }
            }
            $this->addFlash('success', $translator->trans('The user has been enabled'));
        }
        $em->persist($user);
        $em->flush();
        return $services->redirectToReferer('page');
    }

    /**
     * @Route("/administrator/manage-users/{slug}/more-information", name="user_information", methods="GET")
     */
    public function details(AppServices $services, TranslatorInterface $translator, $slug) {

        $user = $services->getUsers(array("slug" => $slug, "enabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$user) {
            return new Response($translator->trans('The user can not be found'));
        }
        return $this->render('Dashboard/Administrator/User/information.html.twig', [
                    'user' => $user,
        ]);
    }

    /**
     * @Route("/administrator/manage-users/{slug}/empty-cart", name="user_empty_cart", methods="GET")
     */
    public function emptyCart(AppServices $services, TranslatorInterface $translator, $slug) {

        $user = $services->getUsers(array("slug" => $slug, "enabled" => "all"))->getQuery()->getOneOrNullResult();
        if (!$user) {
            $this->addFlash('error', $translator->trans('The user can not be found'));
            return $services->redirectToReferer('page');
        }
        $services->emptyCart($user);
        $this->addFlash('notice', $translator->trans('The user cart has been emptied'));
        return $services->redirectToReferer('page');
    }

}
