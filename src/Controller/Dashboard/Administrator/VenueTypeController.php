<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\VenueType;
use App\Form\VenueTypeType;
use Symfony\Contracts\Translation\TranslatorInterface;

class VenueTypeController extends Controller {

    /**
     * @Route("/manage-venues-types", name="venuetype", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');

        $venuestypes = $paginator->paginate($services->getVenuesTypes(array('keyword' => $keyword, 'hidden' => 'all', 'sort' => 'v.createdAt', 'order' => 'DESC')), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/VenueType/index.html.twig', [
                    'venuestypes' => $venuestypes,
        ]);
    }

    /**
     * @Route("/manage-venues-types/add", name="venuetype_add", methods="GET|POST")
     * @Route("/manage-venues-types/{slug}/edit", name="venuetype_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $venuetype = new VenueType();
        } else {
            $venuetype = $services->getVenuesTypes(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$venuetype) {
                $this->addFlash('error', $translator->trans('The venue type can not be found'));
                return $services->redirectToReferer('venuetype');
            }
        }

        $form = $this->createForm(VenueTypeType::class, $venuetype);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($venuetype);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The venue type has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The venue type has been successfully updated'));
                }
                return $this->redirectToRoute('dashboard_administrator_venuetype');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/VenueType/add-edit.html.twig', array(
                    "venuetype" => $venuetype,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-venues-types/{slug}/disable", name="venuetype_disable", methods="GET")
     * @Route("/manage-venues-types/{slug}/delete", name="venuetype_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $venuetype = $services->getVenuesTypes(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$venuetype) {
            $this->addFlash('error', $translator->trans('The venue type can not be found'));
            return $services->redirectToReferer('venuetype');
        }
        if (count($venuetype->getVenues()) > 0) {
            $this->addFlash('error', $translator->trans('The venue type can not be deleted because it is linked with one or more venues'));
            return $services->redirectToReferer('venuetype');
        }
        if ($venuetype->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The venue type has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The venue type has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $venuetype->setHidden(true);
        $em->persist($venuetype);
        $em->flush();
        $em->remove($venuetype);
        $em->flush();
        return $services->redirectToReferer('venuetype');
    }

    /**
     * @Route("/manage-venues-types/{slug}/restore", name="venuetype_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $venuetype = $services->getVenuesTypes(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$venuetype) {
            $this->addFlash('error', $translator->trans('The venue type can not be found'));
            return $services->redirectToReferer('venuetype');
        }
        $venuetype->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($venuetype);
        $em->flush();
        $this->addFlash('success', $translator->trans('The venue type has been succesfully restored'));

        return $services->redirectToReferer('venuetype');
    }

    /**
     * @Route("/manage-venues-types/{slug}/show", name="venuetype_show", methods="GET")
     * @Route("/manage-venues-types/{slug}/hide", name="venuetype_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $venuetype = $services->getVenuesTypes(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$venuetype) {
            $this->addFlash('error', $translator->trans('The venue type can not be found'));
            return $services->redirectToReferer('venuetype');
        }
        if ($venuetype->getHidden() === true) {
            $venuetype->setHidden(false);
            $this->addFlash('success', $translator->trans('The venue type is visible'));
        } else {
            $venuetype->setHidden(true);
            $this->addFlash('error', $translator->trans('The venue type is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($venuetype);
        $em->flush();
        return $services->redirectToReferer('venuetype');
    }

}
