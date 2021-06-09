<?php

namespace App\Feed;

use FeedIo\Feed;
use FeedIo\FeedInterface;
use FeedIo\Feed\Item;
use Debril\RssAtomBundle\Provider\FeedProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\AppServices;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FeedIo\Feed\Node\Category;
use FeedIo\Feed\Item\Media;
use Symfony\Component\Asset\Packages;

class Provider implements FeedProviderInterface {

    protected $services;
    protected $router;
    protected $assets;

    public function __construct(AppServices $services, UrlGeneratorInterface $router, Packages $assets) {
        $this->services = $services;
        $this->router = $router;
        $this->assets = $assets;
    }

    /**
     * @param array $options
     * @return \FeedIo\FeedInterface
     * @throws \Debril\RssAtomBundle\Exception\FeedNotFoundException
     */
    public function getFeed(Request $request): FeedInterface {
        $feed = new Feed();
        $feed->setTitle($this->services->getSetting("feed_name"))
                ->setLink($this->services->getSetting("website_url") . "/rss")
                ->setDescription($this->services->getSetting("feed_description"));
        $lastEventUpdatedDate = null;
        foreach ($this->getEvents() as $item) {
            $lastEventUpdatedDate = is_null($lastEventUpdatedDate) ? $item->getLastModified() : $lastEventUpdatedDate;
            $feed->add($item);
        }
        $lastEventUpdatedDate = is_null($lastEventUpdatedDate) ? new \DateTime() : $lastEventUpdatedDate;
        $feed->setLastModified($lastEventUpdatedDate);
        return $feed;
    }

    protected function getEvents() {
        foreach ($this->services->getEvents(array("limit" => $this->services->getSetting("feed_events_limit")))->getQuery()->getResult() as $event) {
            $item = new Item;
            $item->setTitle($event->getName());
            $item->getAuthor($event->getOrganizer()->getName());
            $item->setLink($this->router->generate("event", ["slug" => $event->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL));
            $media = new Media();
            $media->setUrl($this->services->getSetting("website_url") . $this->assets->getUrl($event->getImagePath()));
            $item->addMedia($media);
            $category = new Category();
            $category->setLabel($event->getCategory()->getName());
            $item->addCategory($category);
            $item->setLastModified($event->getUpdatedAt());
            yield $item;
        }
    }

}
