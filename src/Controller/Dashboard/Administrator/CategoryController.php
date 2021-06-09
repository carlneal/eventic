<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryController extends Controller {

    /**
     * @Route("/manage-categories", name="category", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');
        $featured = ($request->query->get('featured')) == "" ? "all" : $request->query->get('featured');

        $categories = $paginator->paginate($services->getCategories(array('keyword' => $keyword, 'hidden' => 'all', 'featured' => $featured, 'sort' => 'c.createdAt', 'order' => 'DESC')), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/Category/index.html.twig', [
                    'categories' => $categories,
        ]);
    }

    /**
     * @Route("/manage-categories/add", name="category_add", methods="GET|POST")
     * @Route("/manage-categories/{slug}/edit", name="category_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $category = new Category();
        } else {
            $category = $services->getCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$category) {
                $this->addFlash('error', $translator->trans('The category can not be found'));
                return $services->redirectToReferer('category');
            }
        }

        $form = $this->createForm(CategoryType::class, $category);
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
                return $this->redirectToRoute('dashboard_administrator_category');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/Category/add-edit.html.twig', array(
                    "category" => $category,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-categories/{slug}/disable", name="category_disable", methods="GET")
     * @Route("/manage-categories/{slug}/delete", name="category_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $category = $services->getCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$category) {
            $this->addFlash('error', $translator->trans('The category can not be found'));
            return $services->redirectToReferer('category');
        }
        if (count($category->getEvents()) > 0) {
            $this->addFlash('error', $translator->trans('The category can not be deleted because it is linked with one or more events'));
            return $services->redirectToReferer('category');
        }
        if ($category->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The category has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The category has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $category->setFeatured(false);
        $category->setHidden(true);
        $em->persist($category);
        $em->flush();
        $em->remove($category);
        $em->flush();
        return $services->redirectToReferer('category');
    }

    /**
     * @Route("/manage-categories/{slug}/restore", name="category_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $category = $services->getCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$category) {
            $this->addFlash('error', $translator->trans('The category can not be found'));
            return $services->redirectToReferer('category');
        }
        $category->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        $this->addFlash('success', $translator->trans('The category has been succesfully restored'));

        return $services->redirectToReferer('category');
    }

    /**
     * @Route("/manage-categories/{slug}/show", name="category_show", methods="GET")
     * @Route("/manage-categories/{slug}/hide", name="category_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $category = $services->getCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$category) {
            $this->addFlash('error', $translator->trans('The category can not be found'));
            return $services->redirectToReferer('category');
        }
        if ($category->getHidden() === true) {
            $category->setHidden(false);
            $this->addFlash('success', $translator->trans('The category is visible'));
        } else {
            $category->setFeatured(false);
            $category->setHidden(true);
            $this->addFlash('error', $translator->trans('The category is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        return $services->redirectToReferer('category');
    }

    /**
     * @Route("/manage-categories/{slug}/featured", name="category_featured", methods="GET")
     * @Route("/manage-categories/{slug}/notfeatured", name="category_notfeatured", methods="GET")
     */
    public function featured(AppServices $services, TranslatorInterface $translator, $slug) {

        $category = $services->getCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$category) {
            $this->addFlash('error', $translator->trans('The category can not be found'));
            return $services->redirectToReferer('category');
        }
        if ($category->getFeatured() === true) {
            $category->setFeatured(false);
            $category->setFeaturedorder(null);
            $this->addFlash('error', $translator->trans('The category is not featured anymore and is removed from the homepage categories'));
        } else {
            $category->setFeatured(true);
            $this->addFlash('success', $translator->trans('The category is featured and is shown in the homepage categories'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        return $services->redirectToReferer('category');
    }

}
