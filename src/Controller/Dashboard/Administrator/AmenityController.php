<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use App\Entity\Amenity;
use App\Form\AmenityType;
use Symfony\Contracts\Translation\TranslatorInterface;

class AmenityController extends Controller {

    /**
     * @Route("/manage-amenities", name="amenity", methods="GET")
     */
    public function index(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');

        $amenities = $paginator->paginate($services->getAmenities(array('keyword' => $keyword, 'hidden' => 'all', 'sort' => 'a.createdAt', 'order' => 'DESC')), $request->query->getInt('page', 1), 10, array('wrap-queries' => true));

        return $this->render('Dashboard/Administrator/Amenity/index.html.twig', [
                    'amenities' => $amenities,
        ]);
    }

    /**
     * @Route("/manage-amenities/add", name="amenity_add", methods="GET|POST")
     * @Route("/manage-amenities/{slug}/edit", name="amenity_edit", methods="GET|POST")
     */
    public function addedit(Request $request, AppServices $services, TranslatorInterface $translator, $slug = null) {
        $em = $this->getDoctrine()->getManager();

        if (!$slug) {
            $amenity = new Amenity();
        } else {
            $amenity = $services->getAmenities(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
            if (!$amenity) {
                $this->addFlash('error', $translator->trans('The amenity can not be found'));
                return $services->redirectToReferer('amenity');
            }
        }

        $form = $this->createForm(AmenityType::class, $amenity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($amenity);
                $em->flush();
                if (!$slug) {
                    $this->addFlash('success', $translator->trans('The amenity has been successfully created'));
                } else {
                    $this->addFlash('success', $translator->trans('The amenity has been successfully updated'));
                }
                return $this->redirectToRoute('dashboard_administrator_amenity');
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }
        return $this->render('Dashboard/Administrator/Amenity/add-edit.html.twig', array(
                    "amenity" => $amenity,
                    "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/manage-amenities/{slug}/disable", name="amenity_disable", methods="GET")
     * @Route("/manage-amenities/{slug}/delete", name="amenity_delete", methods="GET")
     */
    public function delete(AppServices $services, TranslatorInterface $translator, $slug) {

        $amenity = $services->getAmenities(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$amenity) {
            $this->addFlash('error', $translator->trans('The amenity can not be found'));
            return $services->redirectToReferer('amenity');
        }
        if (count($amenity->getVenues()) > 0) {
            $this->addFlash('error', $translator->trans('The amenity can not be deleted because it is linked with one or more venues'));
            return $services->redirectToReferer('amenity');
        }
        if ($amenity->getDeletedAt() !== null) {
            $this->addFlash('error', $translator->trans('The amenity has been deleted'));
        } else {
            $this->addFlash('notice', $translator->trans('The amenity has been disabled'));
        }
        $em = $this->getDoctrine()->getManager();
        $amenity->setHidden(true);
        $em->persist($amenity);
        $em->flush();
        $em->remove($amenity);
        $em->flush();
        return $services->redirectToReferer('amenity');
    }

    /**
     * @Route("/manage-amenities/{slug}/restore", name="amenity_restore", methods="GET")
     */
    public function restore($slug, Request $request, TranslatorInterface $translator, AppServices $services) {

        $amenity = $services->getAmenities(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$amenity) {
            $this->addFlash('error', $translator->trans('The amenity can not be found'));
            return $services->redirectToReferer('amenity');
        }
        $amenity->setDeletedAt(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($amenity);
        $em->flush();
        $this->addFlash('success', $translator->trans('The amenity has been succesfully restored'));

        return $services->redirectToReferer('amenity');
    }

    /**
     * @Route("/manage-amenities/{slug}/show", name="amenity_show", methods="GET")
     * @Route("/manage-amenities/{slug}/hide", name="amenity_hide", methods="GET")
     */
    public function showhide(AppServices $services, TranslatorInterface $translator, $slug) {

        $amenity = $services->getAmenities(array('hidden' => 'all', 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$amenity) {
            $this->addFlash('error', $translator->trans('The amenity can not be found'));
            return $services->redirectToReferer('amenity');
        }
        if ($amenity->getHidden() === true) {
            $amenity->setHidden(false);
            $this->addFlash('success', $translator->trans('The amenity is visible'));
        } else {
            $amenity->setHidden(true);
            $this->addFlash('error', $translator->trans('The amenity is hidden'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($amenity);
        $em->flush();
        return $services->redirectToReferer('amenity');
    }

}
