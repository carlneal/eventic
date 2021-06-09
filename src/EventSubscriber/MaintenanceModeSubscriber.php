<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\AppServices;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceModeSubscriber implements EventSubscriberInterface {

    private $params;
    private $security;
    private $translator;
    private $templating;
    private $services;

    public function __construct(ParameterBagInterface $params, Security $security, TranslatorInterface $translator, \Twig_Environment $templating, AppServices $services) {
        $this->params = $params;
        $this->security = $security;
        $this->translator = $translator;
        $this->templating = $templating;
        $this->services = $services;
    }

    public function onKernelController(ControllerEvent $event) {

        try {
            if ($this->params->get('maintenance_mode') == '1' && !$this->security->isGranted('ROLE_ADMINISTRATOR')) {
                $event->setController(
                        function() {
                    return new Response($this->templating->render('Front/Page/maintenance-mode.html.twig', array('customMessage' => $this->services->getSetting('maintenance_mode_custom_message')), 503));
                });
            }
        } catch (AuthenticationCredentialsNotFoundException $e) {

        }
    }

    public static function getSubscribedEvents() {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

}

?>