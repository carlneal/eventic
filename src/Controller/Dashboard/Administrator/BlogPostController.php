<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\BlogPost;
use App\Form\BlogPostType;
use Symfony\Contracts\Translation\TranslatorInterface;

class BlogPostController extends Controller {

    /**
     * @Route("/manage-blog-posts", name="blog_post", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');

        $blogposts = $paginator->paginate($services->getBlogPosts(array('keyword' => $keyword, 'hidden' => 'all')), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/BlogPost/index.html.twig', [
                    'blogposts' => $blogposts,
        ]);
    }

    /**
     * @Route("/manage-blog-posts/add", name="blog_post_add", methods="GET|POST")
     * @Route("/manage-blog-posts/{slug}/edit", name="blog_post_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $blogpost = new BlogPost();
        } else {
            $blogpost = $services->getBlogPosts(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$blogpost) {
                $this->addFlash('error', $translator->trans('The blog post can not be found'));
                return $services->redirectToReferer('blog_post');
            }
        }

        $form = $this->createForm(BlogPostType::class, $blogpost);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($blogpost);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The blog post has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The blog post has been successfully updated'));
                }
                return $this->redirectToRoute("dashboard_administrator_blog_post");
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/BlogPost/add-edit.html.twig', array(
                    "blogpost" => $blogpost,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-blog-posts/{slug}/disable", name="blog_post_disable", methods="GET")
     * @Route("/manage-blog-posts/{slug}/delete", name="blog_post_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $blogpost = $services->getBlogPosts(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$blogpost) {
            $this->addFlash('error', $translator->trans('The blog post can not be found'));
            return $services->redirectToReferer('blog_post');
        }
        if ($blogpost->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The blog post has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The blog post has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $blogpost->setHidden(true);
        $em->persist($blogpost);
        $em->flush();
        $em->remove($blogpost);
        $em->flush();
        return $services->redirectToReferer('blog_post');
    }

    /**
     * @Route("/manage-blog-posts/{slug}/restore", name="blog_post_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $blogpost = $services->getBlogPosts(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$blogpost) {
            $this->addFlash('error', $translator->trans('The blog post can not be found'));
            return $services->redirectToReferer('blog_post');
        }
        $blogpost->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($blogpost);
        $em->flush();
        $this->addFlash('success', $translator->trans('The blog post has been succesfully restored'));

        return $services->redirectToReferer('blog_post');
    }

    /**
     * @Route("/manage-blog-posts/{slug}/show", name="blog_post_show", methods="GET")
     * @Route("/manage-blog-posts/{slug}/hide", name="blog_post_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $blogpost = $services->getBlogPosts(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$blogpost) {
            $this->addFlash('error', $translator->trans('The blog post can not be found'));
            return $services->redirectToReferer('blog_post');
        }
        if ($blogpost->getHidden() === true) {
            $blogpost->setHidden(false);
            $this->addFlash('success', $translator->trans('The blog post is visible'));
        } else {
            $blogpost->setHidden(true);
            $this->addFlash('error', $translator->trans('The blog post is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($blogpost);
        $em->flush();
        return $services->redirectToReferer('blog_post');
    }

}
