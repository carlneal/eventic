<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\AppServices;
use App\Entity\Page;
use App\Form\PageType;
use Symfony\Contracts\Translation\TranslatorInterface;

class PageController extends Controller {

    /**
     * @Route("/manage-pages", name="page", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {

        $pages = $paginator->paginate($services->getPages(array()), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/Page/index.html.twig', [
                    'pages' => $pages,
        ]);
    }

    /**
     * @Route("/manage-pages/add", name="page_add", methods="GET|POST")
     * @Route("/manage-pages/{slug}/edit", name="page_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $page = new Page();
        } else {
            $page = $services->getPages(array('slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$page) {
                $this->addFlash('error', $translator->trans('The page can not be found'));
                return $services->redirectToReferer('page');
            }
        }

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($page);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The page has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The page has been successfully updated'));
                }
                return $this->redirectToRoute('dashboard_administrator_page');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/Page/add-edit.html.twig', array(
                    "page" => $page,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-pages/{slug}/delete", name="page_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $page = $services->getPages(array('slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$page) {
            $this->addFlash('error', $translator->trans('The page can not be found'));
            return $services->redirectToReferer('page');
        }
        $this->addFlash('error', $translator->trans('The page has been deleted'));
        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();
        return $services->redirectToReferer('page');
    }

}
