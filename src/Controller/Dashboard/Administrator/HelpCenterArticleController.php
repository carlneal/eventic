<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\HelpCenterArticle;
use App\Form\HelpCenterArticleType;
use Symfony\Contracts\Translation\TranslatorInterface;

class HelpCenterArticleController extends Controller {

    /**
     * @Route("/manage-help-center/articles", name="help_center_article", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');

        $articles = $paginator->paginate($services->getHelpCenterArticles(array('keyword' => $keyword, 'hidden' => 'all', 'sort' => 'updatedAt', 'order' => 'DESC')), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/HelpCenter/Article/index.html.twig', [
                    'articles' => $articles,
        ]);
    }

    /**
     * @Route("/manage-help-center/articles/add", name="help_center_article_add", methods="GET|POST")
     * @Route("/manage-help-center/articles/{slug}/edit", name="help_center_article_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $article = new HelpCenterArticle();
        } else {
            $article = $services->getHelpCenterArticles(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$article) {
                $this->addFlash('error', $translator->trans('The article can not be found'));
                return $services->redirectToReferer('help_center_article');
            }
        }

        $form = $this->createForm(HelpCenterArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($article);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The article has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The article has been successfully updated'));
                }
                return $this->redirectToRoute("dashboard_administrator_help_center_article");
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/HelpCenter/Article/add-edit.html.twig', array(
                    "article" => $article,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-help-center/articles/{slug}/featured", name="help_center_article_featured", methods="GET")
     * @Route("/manage-help-center/articles/{slug}/notfeatured", name="help_center_article_notfeatured", methods="GET")
     */
    public function featured(AppServices $services, TranslatorInterface $translator, $slug) {

        $article = $services->getHelpCenterArticles(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$article) {
            $this->addFlash('error', $translator->trans('The article can not be found'));
            return $services->redirectToReferer('help_center_article');
        }
        if ($article->getFeatured() === true) {
            $article->setFeatured(false);
            $this->addFlash('error', $translator->trans('The article is not featured anymore'));
        } else {
            $article->setFeatured(true);
            $this->addFlash('success', $translator->trans('The article is featured'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return $this->redirectToRoute('dashboard_administrator_help_center_article');
    }

    /**
     * @Route("/manage-help-center/articles/{slug}/disable", name="help_center_article_disable", methods="GET")
     * @Route("/manage-help-center/articles/{slug}/delete", name="help_center_article_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $article = $services->getHelpCenterArticles(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$article) {
            $this->addFlash('error', $translator->trans('The article can not be found'));
            return $services->redirectToReferer('help_center_article');
        }
        if ($article->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The article has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The article has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $article->setHidden(true);
        $em->persist($article);
        $em->flush();
        $em->remove($article);
        $em->flush();
        return $services->redirectToReferer('help_center_article');
    }

    /**
     * @Route("/manage-help-center/articles/{slug}/restore", name="help_center_article_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $article = $services->getHelpCenterArticles(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$article) {
            $this->addFlash('error', $translator->trans('The article can not be found'));
            return $services->redirectToReferer('help_center_article');
        }
        $article->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        $this->addFlash('success', $translator->trans('The article has been succesfully restored'));

        return $services->redirectToReferer('help_center_article');
    }

    /**
     * @Route("/manage-help-center/articles/{slug}/show", name="help_center_article_show", methods="GET")
     * @Route("/manage-help-center/articles/{slug}/hide", name="help_center_article_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $article = $services->getHelpCenterArticles(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$article) {
            $this->addFlash('error', $translator->trans('The article can not be found'));
            return $services->redirectToReferer('help_center_article');
        }
        if ($article->getHidden() === true) {
            $article->setHidden(false);
            $this->addFlash('success', $translator->trans('The article is visible'));
        } else {
            $article->setHidden(true);
            $this->addFlash('error', $translator->trans('The article is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return $services->redirectToReferer('help_center_article');
    }

}
