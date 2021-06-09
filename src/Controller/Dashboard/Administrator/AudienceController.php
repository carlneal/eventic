<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\Audience;
use App\Form\AudienceType;
use Symfony\Contracts\Translation\TranslatorInterface;

class AudienceController extends Controller {

    /**
     * @Route("/manage-audiences", name="audience", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');

        $audiences = $paginator->paginate($services->getAudiences(array('keyword' => $keyword, 'hidden' => 'all', 'sort' => 'a.createdAt', 'order' => 'DESC')), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/Audience/index.html.twig', [
                    'audiences' => $audiences,
        ]);
    }

    /**
     * @Route("/manage-audiences/add", name="audience_add", methods="GET|POST")
     * @Route("/manage-audiences/{slug}/edit", name="audience_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $audience = new Audience();
        } else {
            $audience = $services->getAudiences(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$audience) {
                $this->addFlash('error', $translator->trans('The audience can not be found'));
                return $services->redirectToReferer('audience');
            }
        }

        $form = $this->createForm(AudienceType::class, $audience);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($audience);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The audience has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The audience has been successfully updated'));
                }
                return $this->redirectToRoute('dashboard_administrator_audience');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/Audience/add-edit.html.twig', array(
                    "audience" => $audience,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-audiences/{slug}/disable", name="audience_disable", methods="GET")
     * @Route("/manage-audiences/{slug}/delete", name="audience_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $audience = $services->getAudiences(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$audience) {
            $this->addFlash('error', $translator->trans('The audience can not be found'));
            return $services->redirectToReferer('audience');
        }
        if (count($audience->getEvents()) > 0) {
            $this->addFlash('error', $translator->trans('The audience can not be deleted because it is linked with one or more events'));
            return $services->redirectToReferer('audience');
        }
        if ($audience->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The audience has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The audience has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $audience->setHidden(true);
        $em->persist($audience);
        $em->flush();
        $em->remove($audience);
        $em->flush();
        return $services->redirectToReferer('audience');
    }

    /**
     * @Route("/manage-audiences/{slug}/restore", name="audience_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $audience = $services->getAudiences(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$audience) {
            $this->addFlash('error', $translator->trans('The audience can not be found'));
            return $services->redirectToReferer('audience');
        }
        $audience->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($audience);
        $em->flush();
        $this->addFlash('success', $translator->trans('The audience has been succesfully restored'));

        return $services->redirectToReferer('audience');
    }

    /**
     * @Route("/manage-audiences/{slug}/show", name="audience_show", methods="GET")
     * @Route("/manage-audiences/{slug}/hide", name="audience_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $audience = $services->getAudiences(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$audience) {
            $this->addFlash('error', $translator->trans('The audience can not be found'));
            return $services->redirectToReferer('audience');
        }
        if ($audience->getHidden() === true) {
            $audience->setHidden(false);
            $this->addFlash('success', $translator->trans('The audience is visible'));
        } else {
            $audience->setHidden(true);
            $this->addFlash('error', $translator->trans('The audience is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($audience);
        $em->flush();
        return $services->redirectToReferer('audience');
    }

}
