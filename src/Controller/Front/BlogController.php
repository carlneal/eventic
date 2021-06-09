<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class BlogController extends AbstractController {

    /**
     * @Route("/blog/{category}", name="blog")
     */
    public function blog(Request $request, PaginatorInterface $paginator, AppServices $services, $category = "all") {

        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');
        $blogposts = $paginator->paginate($services->getBlogPosts(array("category" => $category, "keyword" => $keyword))->getQuery(), $request->query->getInt('page', 1), $services->getSetting("blog_posts_per_page"), array('wrap-queries' => true));

        return $this->render('Front/Blog/blog.html.twig', [
                    'blogposts' => $blogposts
        ]);
    }

    /**
     * @Route("/blog-article/{slug}", name="blog_article")
     */
    public function blogArticle($slug, AppServices $services, TranslatorInterface $translator) {
        $blogpost = $services->getBlogPosts(array("slug" => $slug))->getQuery()->getOneOrNullResult();
        if (!$blogpost) {
            $this->addFlash('error', $translator->trans('The blog post not be found'));
            return $this->redirectToRoute('blog');
        }
        $blogpost->viewed();
        $em = $this->getDoctrine()->getManager();
        $em->persist($blogpost);
        $em->flush();

        return $this->render('Front/Blog/blog-article.html.twig', ["blogpost" => $blogpost]);
    }

}
