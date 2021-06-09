<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\Language;
use App\Form\LanguageType;
use Symfony\Contracts\Translation\TranslatorInterface;

class LanguageController extends Controller {

    /**
     * @Route("/manage-languages", name="language", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');

        $languages = $paginator->paginate($services->getLanguages(array('keyword' => $keyword, 'hidden' => 'all', 'sort' => 'l.createdAt', 'order' => 'DESC')), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/Language/index.html.twig', [
                    'languages' => $languages,
        ]);
    }

    /**
     * @Route("/manage-languages/add", name="language_add", methods="GET|POST")
     * @Route("/manage-languages/{slug}/edit", name="language_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $language = new Language();
        } else {
            $language = $services->getLanguages(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$language) {
                $this->addFlash('error', $translator->trans('The language can not be found'));
                return $services->redirectToReferer('language');
            }
        }

        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($language);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The language has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The language has been successfully updated'));
                }
                return $this->redirectToRoute('dashboard_administrator_language');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/Language/add-edit.html.twig', array(
                    "language" => $language,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-languages/{slug}/disable", name="language_disable", methods="GET")
     * @Route("/manage-languages/{slug}/delete", name="language_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $language = $services->getLanguages(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$language) {
            $this->addFlash('error', $translator->trans('The language can not be found'));
            return $services->redirectToReferer('language');
        }
        if (count($language->getEvents()) > 0) {
            $this->addFlash('error', $translator->trans('The language can not be deleted because it is linked with one or more events'));
            return $services->redirectToReferer('language');
        }
        if ($language->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The language has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The language has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $language->setHidden(true);
        $em->persist($language);
        $em->flush();
        $em->remove($language);
        $em->flush();
        return $services->redirectToReferer('language');
    }

    /**
     * @Route("/manage-languages/{slug}/restore", name="language_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $language = $services->getLanguages(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$language) {
            $this->addFlash('error', $translator->trans('The language can not be found'));
            return $services->redirectToReferer('language');
        }
        $language->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($language);
        $em->flush();
        $this->addFlash('success', $translator->trans('The language has been succesfully restored'));

        return $services->redirectToReferer('language');
    }

    /**
     * @Route("/manage-languages/{slug}/show", name="language_show", methods="GET")
     * @Route("/manage-languages/{slug}/hide", name="language_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $language = $services->getLanguages(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$language) {
            $this->addFlash('error', $translator->trans('The language can not be found'));
            return $services->redirectToReferer('language');
        }
        if ($language->getHidden() === true) {
            $language->setHidden(false);
            $this->addFlash('success', $translator->trans('The language is visible'));
        } else {
            $language->setHidden(true);
            $this->addFlash('error', $translator->trans('The language is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($language);
        $em->flush();
        return $services->redirectToReferer('language');
    }

}
