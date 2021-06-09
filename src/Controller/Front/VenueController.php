<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\AppServices;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Form\VenueQuoteType;

class VenueController extends AbstractController {

    /**
     * @Route("/venues", name="venues")
     */
    public function venues(Request $request, PaginatorInterface $paginator, AppServices $services) {
        $keyword = ($request->query->get('keyword')) == "" ? "all" : $request->query->get('keyword');
        $country = ($request->query->get('country')) == "" ? "all" : $request->query->get('country');
        $venuetypes = ($request->query->get('venuetypes')) == "" ? "all" : $request->query->get('venuetypes');
        $minseatedguests = ($request->query->get('minseatedguests')) == "" ? "all" : $request->query->get('minseatedguests');
        $maxseatedguests = ($request->query->get('maxseatedguests')) == "" ? "all" : $request->query->get('maxseatedguests');
        $minstandingguests = ($request->query->get('minstandingguests')) == "" ? "all" : $request->query->get('minstandingguests');
        $maxstandingguests = ($request->query->get('maxstandingguests')) == "" ? "all" : $request->query->get('maxstandingguests');
        $venues = $paginator->paginate($services->getVenues(array('directory' => true, 'keyword' => $keyword, 'country' => $country, 'venuetypes' => $venuetypes, 'minseatedguests' => $minseatedguests, 'maxseatedguests' => $maxseatedguests, 'minstandingguests' => $minstandingguests, 'maxstandingguests' => $maxstandingguests)), $request->query->getInt('page', 1), 8);
        return $this->render('Front/Venue/venues.html.twig', [
                    'venues' => $venues
        ]);
    }

    /**
     * @Route("/venue/{slug}", name="venue")
     */
    public function venue(Request $request, $slug, AppServices $services, TranslatorInterface $translator, \Swift_Mailer $mailer) {
        $venue = $services->getVenues(array('directory' => true, 'slug' => $slug))->getQuery()->getOneOrNullResult();
        if (!$venue) {
            $this->addFlash('error', $translator->trans('The venue can not be found'));
            return $this->redirectToRoute('venues');
        }

        $form = $this->createForm(VenueQuoteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $quoterequest = $form->getData();
                $email = (new \Swift_Message($translator->trans('New quote request')))
                        ->setFrom($services->getSetting("no_reply_email"))
                        ->setTo($venue->getContactemail())
                        ->setBody(
                        $this->renderView(
                                'Front/Venue/email.html.twig', ['quoterequest' => $quoterequest, 'venue' => $venue]
                        ), 'text/html'
                );
                $mailer->send($email);
                $this->addFlash('success', $translator->trans('Your quote request has been successfully sent'));
                $this->redirectToRoute("venue", ['slug' => $venue->getSlug()]);
            } else {
                $this->addFlash('error', $translator->trans('The form contains invalid data'));
            }
        }

        return $this->render('Front/Venue/venue.html.twig', [
                    'venue' => $venue,
                    'form' => $form->createView()
        ]);
    }

}
