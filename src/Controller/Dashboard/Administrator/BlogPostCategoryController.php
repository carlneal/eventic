<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\BlogPostCategory;
use App\Form\BlogPostCategoryType;
use Symfony\Contracts\Translation\TranslatorInterface;

class BlogPostCategoryController extends Controller {

    /**
     * @Route("/manage-blog-post-categories", name="blog_post_category", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');

        $blogpostcategories = $paginator->paginate($services->getBlogPostCategories(array('keyword' => $keyword, 'hidden' => 'all', 'order' => 'b.createdAt', 'sort' => 'DESC')), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/BlogPostCategory/index.html.twig', [
                    'blogpostcategories' => $blogpostcategories,
        ]);
    }

    /**
     * @Route("/manage-blog-post-categories/add", name="blog_post_category_add", methods="GET|POST")
     * @Route("/manage-blog-post-categories/{slug}/edit", name="blog_post_category_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $blogpostcategory = new BlogPostCategory();
        } else {
            $blogpostcategory = $services->getBlogPostCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$blogpostcategory) {
                $this->addFlash('error', $translator->trans('The blog post category can not be found'));
                return $services->redirectToReferer('blog_post_category');
            }
        }

        $form = $this->createForm(BlogPostCategoryType::class, $blogpostcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($blogpostcategory);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The blog post category has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The blog post category has been successfully updated'));
                }
                return $this->redirectToRoute("dashboard_administrator_blog_post_category");
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/BlogPostCategory/add-edit.html.twig', array(
                    "blogpostcategory" => $blogpostcategory,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-blog-post-categories/{slug}/disable", name="blog_post_category_disable", methods="GET")
     * @Route("/manage-blog-post-categories/{slug}/delete", name="blog_post_category_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $blogpostcategory = $services->getBlogPostCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$blogpostcategory) {
            $this->addFlash('error', $translator->trans('The blog post category can not be found'));
            return $services->redirectToReferer('blog_post_category');
        }
        if (count($blogpostcategory->getBlogposts()) > 0) {
            $this->addFlash('error', $translator->trans('The blog post category can not be deleted because it is linked with one or more blog posts'));
            return $services->redirectToReferer('blog_post_category');
        }
        if ($blogpostcategory->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The blog post category has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The blog post category has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $blogpostcategory->setHidden(true);
        $em->persist($blogpostcategory);
        $em->flush();
        $em->remove($blogpostcategory);
        $em->flush();
        return $services->redirectToReferer('blog_post_category');
    }

    /**
     * @Route("/manage-blog-post-categories/{slug}/restore", name="blog_post_category_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $blogpostcategory = $services->getBlogPostCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$blogpostcategory) {
            $this->addFlash('error', $translator->trans('The blog post category can not be found'));
            return $services->redirectToReferer('blog_post_category');
        }
        $blogpostcategory->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($blogpostcategory);
        $em->flush();
        $this->addFlash('success', $translator->trans('The blog post category has been succesfully restored'));

        return $services->redirectToReferer('blog_post_category');
    }

    /**
     * @Route("/manage-blog-post-categories/{slug}/show", name="blog_post_category_show", methods="GET")
     * @Route("/manage-blog-post-categories/{slug}/hide", name="blog_post_category_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $blogpostcategory = $services->getBlogPostCategories(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$blogpostcategory) {
            $this->addFlash('error', $translator->trans('The blog post category can not be found'));
            return $services->redirectToReferer('blog_post_category');
        }
        if ($blogpostcategory->getHidden() === true) {
            $blogpostcategory->setHidden(false);
            $this->addFlash('success', $translator->trans('The blog post category is visible'));
        } else {
            $blogpostcategory->setHidden(true);
            $this->addFlash('error', $translator->trans('The blog post category is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($blogpostcategory);
        $em->flush();
        return $services->redirectToReferer('blog_post_category');
    }

}
