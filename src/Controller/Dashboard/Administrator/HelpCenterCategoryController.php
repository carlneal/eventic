<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\HelpCenterCategory;
use App\Form\HelpCenterCategoryType;
use Symfony\Contracts\Translation\TranslatorInterface;

class HelpCenterCategoryController extends Controller {

    /**
     * @Route("/manage-help-center/categories", name="help_center_category", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');
        $hidden = ($request->query->get('hidden')) == "" ? "all" : $request->query->get('hidden');

        $categories = $paginator->paginate($services->getHelpCenterCategories(array('keyword' => $keyword, 'hidden' => $hidden, 'order' => 'c.createdAt', 'sort' => 'DESC')), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/HelpCenter/Category/index.html.twig', [
                    'categories' => $categories,
        ]);
    }

    /**
     * @Route("/manage-help-center/categories/add", name="help_center_category_add", methods="GET|POST")
     * @Route("/manage-help-center/categories/{slug}/edit", name="help_center_category_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $category = new HelpCenterCategory();
        } else {
            $category = $services->getHelpCenterCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$category) {
                $this->addFlash('error', $translator->trans('The category can not be found'));
                return $services->redirectToReferer('help_center_category');
            }
        }

        $form = $this->createForm(HelpCenterCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($category);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The category has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The category has been successfully updated'));
                }
                return $this->redirectToRoute('dashboard_administrator_help_center_category');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/HelpCenter/Category/add-edit.html.twig', array(
                    "category" => $category,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-help-center/categories/{slug}/disable", name="help_center_category_disable", methods="GET")
     * @Route("/manage-help-center/categories/{slug}/delete", name="help_center_category_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $category = $services->getHelpCenterCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$category) {
            $this->addFlash('error', $translator->trans('The category can not be found'));
            return $services->redirectToReferer('help_center_category');
        }
        if (count($category->getArticles()) > 0) {
            $this->addFlash('error', $translator->trans('The category can not be deleted because it is linked with one or more help center articles'));
            return $services->redirectToReferer('help_center_category');
        }
        if ($category->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The category has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The category has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $category->setHidden(true);
        $em->persist($category);
        $em->flush();
        $em->remove($category);
        $em->flush();
        return $services->redirectToReferer('help_center_category');
    }

    /**
     * @Route("/manage-help-center/categories/{slug}/restore", name="help_center_category_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $category = $services->getHelpCenterCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$category) {
            $this->addFlash('error', $translator->trans('The category can not be found'));
            return $services->redirectToReferer('help_center_category');
        }
        $category->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        $this->addFlash('success', $translator->trans('The category has been succesfully restored'));

        return $services->redirectToReferer('help_center_category');
    }

    /**
     * @Route("/manage-help-center/categories/{slug}/show", name="help_center_category_show", methods="GET")
     * @Route("/manage-help-center/categories/{slug}/hide", name="help_center_category_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $category = $services->getHelpCenterCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$category) {
            $this->addFlash('error', $translator->trans('The category can not be found'));
            return $services->redirectToReferer('help_center_category');
        }
        if ($category->getHidden() === true) {
            $category->setHidden(false);
            $this->addFlash('success', $translator->trans('The category is visible'));
        } else {
            $category->setHidden(true);
            $this->addFlash('error', $translator->trans('The category is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        return $services->redirectToReferer('help_center_category');
    }

}
