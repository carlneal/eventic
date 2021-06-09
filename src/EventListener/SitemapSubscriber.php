<?php

namespace App\EventListener;

use App\Service\AppServices;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Presta\SitemapBundle\Sitemap\Url\GoogleMultilangUrlDecorator;

class SitemapSubscriber implements EventSubscriberInterface {

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var AppServices
     */
    private $services;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param AppServices    $services
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, AppServices $services) {
        $this->urlGenerator = $urlGenerator;
        $this->services = $services;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents() {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populate(SitemapPopulateEvent $event): void {
        $this->registerUrls($event->getUrlContainer());
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerUrls(UrlContainerInterface $urls): void {
        // Register static pages urls
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('categories', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('fos_user_security_login', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('fos_user_resetting_request', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('fos_user_registration_register_attendee', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('fos_user_registration_register_organizer', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('contact', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');

        // Register blog posts urls
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('blog', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $blogPosts = $this->services->getBlogPosts(array())->getQuery()->getResult();
        foreach ($blogPosts as $blogPost) {
            $url = new UrlConcrete($this->urlGenerator->generate('blog_article', ['slug' => $blogPost->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL));
            $decoratedUrl = new GoogleMultilangUrlDecorator($url);
            //$decoratedUrl->addLink($this->urlGenerator->generate('blog_article', ['slug' => $blogPost->getSlug(), '_locale' => 'fr'], UrlGeneratorInterface::ABSOLUTE_URL), 'fr');
            $urls->addUrl($decoratedUrl, 'default');
        }

        // Register events urls
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('events', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $events = $this->services->getEvents(array())->getQuery()->getResult();
        foreach ($events as $event) {
            $url = new UrlConcrete($this->urlGenerator->generate('event', ['slug' => $event->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL));
            $decoratedUrl = new GoogleMultilangUrlDecorator($url);
            $urls->addUrl($decoratedUrl, 'default');
        }

        // Register help center urls
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('help_center', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $helpCenterCategories = $this->services->getHelpCenterCategories(array())->getQuery()->getResult();
        foreach ($helpCenterCategories as $helpCenterCategory) {
            $url = new UrlConcrete($this->urlGenerator->generate('help_center_category', ['slug' => $helpCenterCategory->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL));
            $decoratedUrl = new GoogleMultilangUrlDecorator($url);
            $urls->addUrl($decoratedUrl, 'default');
        }
        $helpCenterArticles = $this->services->getHelpCenterArticles(array())->getQuery()->getResult();
        foreach ($helpCenterArticles as $helpCenterArticle) {
            $url = new UrlConcrete($this->urlGenerator->generate('help_center_article', ['slug' => $helpCenterArticle->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL));
            $decoratedUrl = new GoogleMultilangUrlDecorator($url);
            $urls->addUrl($decoratedUrl, 'default');
        }

        // Register organizers urls
        $organizers = $this->services->getUsers(array('role' => 'organizer'))->getQuery()->getResult();
        foreach ($organizers as $organizer) {
            $url = new UrlConcrete($this->urlGenerator->generate('organizer', ['slug' => $organizer->getOrganizer()->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL));
            $decoratedUrl = new GoogleMultilangUrlDecorator($url);
            $urls->addUrl($decoratedUrl, 'default');
        }

        // Register pages urls
        $pages = $this->services->getPages(array())->getQuery()->getResult();
        foreach ($pages as $page) {
            $url = new UrlConcrete($this->urlGenerator->generate('page', ['slug' => $page->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL));
            $decoratedUrl = new GoogleMultilangUrlDecorator($url);
            $urls->addUrl($decoratedUrl, 'default');
        }

        // Register venues urls
        $urls->addUrl(new UrlConcrete($this->urlGenerator->generate('venues', [], UrlGeneratorInterface::ABSOLUTE_URL)), 'default');
        $venues = $this->services->getVenues(array('directory' => true))->getQuery()->getResult();
        foreach ($venues as $venue) {
            $url = new UrlConcrete($this->urlGenerator->generate('venue', ['slug' => $venue->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL));
            $decoratedUrl = new GoogleMultilangUrlDecorator($url);
            $urls->addUrl($decoratedUrl, 'default');
        }
    }

}
