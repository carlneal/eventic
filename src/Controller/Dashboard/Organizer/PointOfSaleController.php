<?php

namespace App\Controller\Dashboard\Organizer;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\PointOfSale;
use App\Form\PointOfSaleType;
use Symfony\Contracts\Translation\TranslatorInterface;

class PointOfSaleController extends Controller {

    /**
     * @Route("/my-points-of-sale", name="pointofsale", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {

        $username = ($request->query->get('username')) == "" ? "all" : $request->query->get('username');
        $enabled = ($request->query->get('enabled')) == "" ? "all" : $request->query->get('enabled');

        $pointofsales = $paginator->paginate($services->getUsers(array("role" => "pointofsale", "createdbyorganizerslug" => $this->getUser()->getOrganizer()->getSlug(), "username" => $username, "enabled" => $enabled))->getQuery(), $request->query->getInt('page', 1), 10);

        return $this->render('Dashboard/Organizer/PointOfSale/index.html.twig', [
                    'pointofsales' => $pointofsales,
        ]);
    }

    /**
     * @Route("/my-points-of-sale/add", name="pointofsale_add", methods="GET|POST")
     * @Route("/my-points-of-sale/{slug}/edit", name="pointofsale_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $pointofsale = new PointOfSale();
            $form = $this->createForm(PointOfSaleType::class, $pointofsale, array('validation_groups' => 'create'));
        } else {
            $pointofsale = $services->getUsers(array("role" => "pointofsale", "createdbyorganizerslug" => $this->getUser()->getOrganizer()->getSlug(), "enabled" => "all", "slug" => $slug))->getQuery()->getOneOrNullResult();
            if (!$pointofsale) {
                $this->addFlash('error', $translator->trans('The point of sale can not be found'));
                return $this->redirectToRoute('dashboard_organizer_pointofsale');
            }
            $pointofsale = $pointofsale->getPointofsale();
            $form = $this->createForm(PointOfSaleType::class, $pointofsale, array('validation_groups' => 'update'));
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $username = $request->request->get('point_of_sale')['username'];
                $password = $request->request->get('point_of_sale')['password']['first'];

                $usermanager = $this->get('fos_user.user_manager');

                if (!$slug) {
                    if ($usermanager->findUserByUsername($username)) {
                        $this->addFlash('error', $translator->trans('The username already exists'));
                        return $this->redirect($request->headers->get('referer'));
                    }
                    $pointofsale->setOrganizer($this->getUser()->getOrganizer());
                    $em->persist($pointofsale);
                    $em->flush();
                    $user = $usermanager->createUser();
                    $email = $services->generateReference(10) . "@" . $services->getSetting("website_root_url");
                    $user->setUsername($username);
                    $user->setUsernameCanonical($username);
                    $user->setEmail($email);
                    $user->setEmailCanonical($email);
                    $user->setEnabled(true);
                    $user->setPlainPassword($password);
                    $user->setPointofsale($pointofsale);
                    $user->addRole('ROLE_POINTOFSALE');
                    $pointofsale->setUser($user);
                    $usermanager->updateUser($user);
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('success', $translator->trans('The point of sale has been successfully created'));
                } else {
                    if ($usermanager->findUserByUsername($username) && $username !== $pointofsale->getUser()->getUsername()) {
                        $this->addFlash('error', $translator->trans('The username already exists'));
                        return $this->redirect($request->headers->get('referer'));
                    }
                    $pointofsale->getUser()->setUsername($username);
                    if ($password != null) {
                        $pointofsale->getUser()->setPlainPassword($password);
                        $usermanager->updatePassword($pointofsale->getUser());
                    }
                    $this->addFlash('success', $translator->trans('The point of sale has been successfully updated'));
                }
                $em->persist($pointofsale);
                $em->flush();
                return $this->redirectToRoute('dashboard_organizer_pointofsale');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }

        return $this->render('Dashboard/Organizer/PointOfSale/add-edit.html.twig', array(
                    "pointofsale" => $pointofsale,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/my-points-of-sale/{slug}/delete-permanently", name="pointofsale_delete_permanently", methods="GET")
     * @Route("/my-points-of-sale/{slug}/delete", name="pointofsale_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $pointofsale = $services->getUsers(array("role" => "pointofsale", "createdbyorganizerslug" => $this->getUser()->getOrganizer()->getSlug(), "enabled" => "all", "slug" => $slug))->getQuery()->getOneOrNullResult();
        if (!$pointofsale) {
            $this->addFlash('error', $translator->trans('The point of sale can not be found'));
            return $this->redirectToRoute('dashboard_organizer_pointofsale');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($pointofsale);
        $em->flush();
        if ($pointofsale->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The point of sale has been permenently deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The point of sale has been deleted'));
        }
        return $this->redirectToRoute('dashboard_organizer_pointofsale');
    }

    /**
     * @Route("/my-points-of-sale/{slug}/enable", name="pointofsale_enable", methods="GET")
     * @Route("/my-points-of-sale/{slug}/disable", name="pointofsale_disable", methods="GET")
     */
    public function enabledisable(AppServices $services, TranslatorInterface $translator, $slug) {

        $pointofsale = $services->getUsers(array("role" => "pointofsale", "createdbyorganizerslug" => $this->getUser()->getOrganizer()->getSlug(), "enabled" => "all", "slug" => $slug))->getQuery()->getOneOrNullResult();
        if (!$pointofsale) {
            $this->addFlash('error', $translator->trans('The point of sale can not be found'));
            return $this->redirectToRoute('dashboard_organizer_pointofsale');
        }
        if ($pointofsale->isEnabled()) {
            $pointofsale->setEnabled(false);
            $this->addFlash('notice', $translator->trans('The point of sale has been disabled'));
        } else {
            $pointofsale->setEnabled(true);
            $this->addFlash('success', $translator->trans('The point of sale has been enabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($pointofsale);
        $em->flush();
        return $this->redirectToRoute('dashboard_organizer_pointofsale');
    }

}
