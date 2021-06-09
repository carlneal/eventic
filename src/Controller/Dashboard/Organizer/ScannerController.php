<?php

namespace App\Controller\Dashboard\Organizer;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\Scanner;
use App\Form\ScannerType;
use Symfony\Contracts\Translation\TranslatorInterface;

class ScannerController extends Controller {

    /**
     * @Route("/my-scanners", name="scanner", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {

        $username = ($request->query->get('username')) == "" ? "all" : $request->query->get('username');
        $enabled = ($request->query->get('enabled')) == "" ? "all" : $request->query->get('enabled');

        $scanners = $paginator->paginate($services->getUsers(array("role" => "scanner", "createdbyorganizerslug" => $this->getUser()->getOrganizer()->getSlug(), "username" => $username, "enabled" => $enabled))->getQuery(), $request->query->getInt('page', 1), 10);

        return $this->render('Dashboard/Organizer/Scanner/index.html.twig', [
                    'scanners' => $scanners,
        ]);
    }

    /**
     * @Route("/my-scanners/add", name="scanner_add", methods="GET|POST")
     * @Route("/my-scanners/{slug}/edit", name="scanner_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $scanner = new Scanner();
            $form = $this->createForm(ScannerType::class, $scanner, array('validation_groups' => 'create'));
        } else {
            $scanner = $services->getUsers(array("role" => "scanner", "createdbyorganizerslug" => $this->getUser()->getOrganizer()->getSlug(), "enabled" => "all", "slug" => $slug))->getQuery()->getOneOrNullResult();
            if (!$scanner) {
                $this->addFlash('error', $translator->trans('The scanner can not be found'));
                return $this->redirectToRoute('dashboard_organizer_scanner');
            }
            $scanner = $scanner->getScanner();
            $form = $this->createForm(ScannerType::class, $scanner, array('validation_groups' => 'update'));
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $username = $request->request->get('scanner')['username'];
                $password = $request->request->get('scanner')['password']['first'];

                $usermanager = $this->get('fos_user.user_manager');

                if (!$slug) {
                    if ($usermanager->findUserByUsername($username)) {
                        $this->addFlash('error', $translator->trans('The username already exists'));
                        return $this->redirect($request->headers->get('referer'));
                    }
                    $scanner->setOrganizer($this->getUser()->getOrganizer());
                    $em->persist($scanner);
                    $em->flush();
                    $user = $usermanager->createUser();
                    $email = $services->generateReference(10) . "@" . $services->getSetting("website_root_url");
                    $user->setUsername($username);
                    $user->setUsernameCanonical($username);
                    $user->setEmail($email);
                    $user->setEmailCanonical($email);
                    $user->setEnabled(true);
                    $user->setPlainPassword($password);
                    $user->setScanner($scanner);
                    $user->addRole('ROLE_SCANNER');
                    $scanner->setUser($user);
                    $usermanager->updateUser($user);
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('success', $translator->trans('The scanner has been successfully created'));
                } else {
                    if ($usermanager->findUserByUsername($username) && $username !== $scanner->getUser()->getUsername()) {
                        $this->addFlash('error', $translator->trans('The username already exists'));
                        return $this->redirect($request->headers->get('referer'));
                    }
                    $scanner->getUser()->setUsername($username);
                    if ($password != null) {
                        $scanner->getUser()->setPlainPassword($password);
                        $usermanager->updatePassword($scanner->getUser());
                    }
                    $this->addFlash('success', $translator->trans('The scanner has been successfully updated'));
                }
                $em->persist($scanner);
                $em->flush();
                return $this->redirectToRoute('dashboard_organizer_scanner');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Organizer/Scanner/add-edit.html.twig', array(
                    "scanner" => $scanner,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/my-scanners/{slug}/delete-permanently", name="scanner_delete_permanently", methods="GET")
     * @Route("/my-scanners/{slug}/delete", name="scanner_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $scanner = $services->getUsers(array("role" => "scanner", "createdbyorganizerslug" => $this->getUser()->getOrganizer()->getSlug(), "enabled" => "all", "slug" => $slug))->getQuery()->getOneOrNullResult();
        if (!$scanner) {
            $this->addFlash('error', $translator->trans('The scanner can not be found'));
            return $this->redirectToRoute('dashboard_organizer_scanner');
        }
        if ($scanner->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The scanner has been permenently deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The user has been deleted'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($scanner);
        $em->flush();
        return $this->redirectToRoute('dashboard_organizer_scanner');
    }

    /**
     * @Route("/my-scanners/{slug}/enable", name="scanner_enable", methods="GET")
     * @Route("/my-scanners/{slug}/disable", name="scanner_disable", methods="GET")
     */
    public function enabledisable(AppServices $services, TranslatorInterface $translator, $slug) {

        $scanner = $services->getUsers(array("role" => "scanner", "createdbyorganizerslug" => $this->getUser()->getOrganizer()->getSlug(), "enabled" => "all", "slug" => $slug))->getQuery()->getOneOrNullResult();
        if (!$scanner) {
            $this->addFlash('error', $translator->trans('The scanner can not be found'));
            return $this->redirectToRoute('dashboard_organizer_scanner');
        }
        if ($scanner->isEnabled()) {
            $scanner->setEnabled(false);
            $this->addFlash('notice', $translator->trans('The scanner has been disabled'));
        } else {
            $scanner->setEnabled(true);
            $this->addFlash('success', $translator->trans('The scanner has been enabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($scanner);
        $em->flush();
        return $this->redirectToRoute('dashboard_organizer_scanner');
    }

}
