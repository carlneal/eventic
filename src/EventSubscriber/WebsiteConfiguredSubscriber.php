<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WebsiteConfiguredSubscriber implements EventSubscriberInterface {

    private $params;
    private $router;
    private $kernelInterface;

    public function __construct(ParameterBagInterface $params, UrlGeneratorInterface $router, KernelInterface $kernelInterface) {
        $this->params = $params;
        $this->router = $router;
        $this->kernelInterface = $kernelInterface;
    }

    public function warmUpCaches() {
        $application = new Application($this->kernelInterface);
        $application->setAutoExit(false);

        $wampupCacheProd = new \Symfony\Component\Console\Input\ArrayInput([
            'command' => 'cache:warmup',
            'env' => 'prod',
        ]);
        $outputWampupCacheProd = new \Symfony\Component\Console\Output\NullOutput();
        $application->run($wampupCacheProd, $outputWampupCacheProd);

        $wampupCacheDev = new \Symfony\Component\Console\Input\ArrayInput([
            'command' => 'cache:warmup',
            'env' => 'dev',
        ]);
        $outputWampupCacheDev = new \Symfony\Component\Console\Output\NullOutput();
        $application->run($wampupCacheDev, $outputWampupCacheDev);
    }

    public function onRequest(RequestEvent $event) {
        if ($this->params->get('is_website_configured') == '0' && strpos($event->getRequest()->getPathInfo(), 'installer') === false && strpos($event->getRequest()->getPathInfo(), '_wdt') === false) {
            $this->warmUpCaches();
            $event->setResponse(new RedirectResponse($this->router->generate('installer_install')));
        }
    }

    public static function getSubscribedEvents() {
        return [
            KernelEvents::REQUEST => 'onRequest',
        ];
    }

}

?>