<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Event::class);
    }

    public function getEvents($category, $venue, $country, $location, $organizer, $keyword, $slug, $freeonly, $onlineonly, $pricemin, $pricemax, $audience, $startdate, $startdatemin, $startdatemax, $published, $elapsed, $organizerEnabled, $addedtofavoritesby, $onsalebypos, $canbescannedby, $isOnHomepageSlider, $otherthan, $sort, $order, $limit, $count) {
        $qb = $this->createQueryBuilder("e");
        if ($count) {
            $qb->select("COUNT(DISTINCT e)");
        } else {
            $qb->select("DISTINCT e");
        }
        if ($keyword !== "all" || $slug !== "all" || $otherthan) {
            $qb->join("e.translations", "translations");
        }
        if ($category !== "all") {
            $qb->leftJoin("e.category", "category");
            $qb->join("category.translations", "categorytranslations");
            $qb->andWhere("categorytranslations.slug = :category")->setParameter("category", $category);
        }
        if ($venue !== "all" || $country !== "all" || $location !== "all" || $pricemin !== "all" || $pricemax !== "all" || $startdate != "all" || $startdatemin != "all" || $startdatemax != "all" || $sort === "eventdates.startdate" || $elapsed !== "all" || $onsalebypos !== "all" || $onlineonly !== "all") {
            $qb->leftJoin("e.eventdates", "eventdates");
            $qb->leftJoin("eventdates.venue", "venue");
        }
        if ($onlineonly == "1") {
            $qb->andWhere("eventdates.online = 1");
        }
        if ($freeonly == "1" || $pricemin !== "all" || $pricemax !== "all") {
            $qb->leftJoin("eventdates.tickets", "tickets");
        }
        if ($freeonly == "1") {
            $qb->andWhere("tickets.free = 1");
        } elseif ($pricemin !== "all" || $pricemax !== "all") {
            if ($pricemin !== "all") {
                $qb->andWhere("(tickets.price >= :pricemin AND tickets.promotionalprice IS NULL) OR (tickets.promotionalprice >= :pricemin)")->setParameter("pricemin", $pricemin);
            }
            if ($pricemax !== "all") {
                $qb->andWhere("((tickets.price <= :pricemax OR tickets.price IS NULL) AND tickets.promotionalprice IS NULL) OR (tickets.promotionalprice <= :pricemax)")->setParameter("pricemax", $pricemax);
            }
        }
        if ($startdate !== "all") {
            $qb->andWhere("Date(eventdates.startdate) = :startdate")->setParameter("startdate", $startdate);
        }
        if ($startdatemin !== "all") {
            $qb->andWhere("Date(eventdates.startdate) >= :startdatemin")->setParameter("startdatemin", $startdatemin);
        }
        if ($startdatemax !== "all") {
            $qb->andWhere("Date(eventdates.startdate) <= :startdatemax")->setParameter("startdatemax", $startdatemax);
        }
        if ($audience !== "all") {
            $qb->leftJoin("e.audiences", "audiences");
            $qb->leftJoin("audiences.translations", "audiencestranslations");
            $qb->andWhere("audiencestranslations.slug = :audience")->setParameter("audience", $audience);
        }
        if ($venue !== "all") {
            $qb->leftJoin("venue.translations", "venuetranslations");
            $qb->andWhere("venuetranslations.slug = :venue")->setParameter("venue", $venue);
        }
        if ($country !== "all" || $location !== "all") {
            $qb->leftJoin("venue.country", "country");
            $qb->leftJoin("country.translations", "countrytranslations");
        }
        if ($country !== "all") {
            $qb->andWhere("countrytranslations.slug = :country")->setParameter("country", $country);
        }
        if ($location !== "all") {
            $qb->andWhere("countrytranslations.name LIKE :location or :location LIKE countrytranslations.name or venue.state LIKE :location or :location LIKE venue.state or venue.city LIKE :location or :location LIKE venue.city")->setParameter("location", $location);
        }
        if ($organizer !== "all" || $organizerEnabled !== "all") {
            $qb->leftJoin("e.organizer", "organizer");
        }
        if ($organizer !== "all") {
            $qb->andWhere("organizer.slug = :organizer")->setParameter("organizer", $organizer);
        }
        if ($keyword !== "all") {
            $qb->andWhere("translations.name LIKE :keyword or :keyword LIKE translations.name or translations.description LIKE :keyword or :keyword LIKE translations.description or e.tags LIKE :keyword or :keyword LIKE e.tags or e.artists LIKE :keyword or :keyword LIKE e.artists")->setParameter("keyword", "%" . $keyword . "%");
        }
        if ($slug !== "all") {
            $qb->andWhere("translations.slug = :slug")->setParameter("slug", $slug);
        }
        if ($addedtofavoritesby !== "all") {
            $qb->andWhere(":addedtofavoritesbyuser MEMBER OF e.addedtofavoritesby")->setParameter("addedtofavoritesbyuser", $addedtofavoritesby);
        }
        if ($onsalebypos !== "all") {
            $qb->andWhere(":onsalebypos MEMBER OF eventdates.pointofsales")->setParameter("onsalebypos", $onsalebypos);
        }
        if ($canbescannedby !== "all") {
            $qb->andWhere(":canbescannedby MEMBER OF eventdates.scanners")->setParameter("canbescannedby", $canbescannedby);
        }
        if ($isOnHomepageSlider === true) {
            $qb->andWhere("e.isonhomepageslider IS NOT NULL");
        }
        if ($published !== "all") {
            $qb->andWhere("e.published = :published")->setParameter("published", $published);
        }
        if ($otherthan !== "all") {
            $qb->andWhere("translations.slug != :otherthan")->setParameter("otherthan", $otherthan);
            $qb->andWhere("translations.slug = :otherthan")->setParameter("otherthan", $otherthan);
        }
        if ($elapsed !== "all") {
            if ($elapsed === true || $elapsed == "1") {
                $qb->andWhere("eventdates.startdate < CURRENT_TIMESTAMP()");
            } else if ($elapsed === false || $elapsed == "0") {
                $qb->andWhere("eventdates.startdate >= CURRENT_TIMESTAMP()");
            }
        }
        if ($organizerEnabled !== "all") {
            $qb->leftJoin("organizer.user", "user");
            $qb->andWhere("user.enabled = :userEnabled")->setParameter("userEnabled", $organizerEnabled);
        }
        $qb->orderBy($sort, $order);
        if ($limit !== "all") {
            $qb->setMaxResults($limit);
        }

        return $qb;
    }

}
