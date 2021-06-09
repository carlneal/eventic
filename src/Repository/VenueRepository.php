<?php

namespace App\Repository;

use App\Entity\Venue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VenueRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Venue::class);
    }

    public function getVenues($organizer, $hidden, $keyword, $country, $venuetypes, $directory, $slug, $limit, $minseatedguests, $maxseatedguests, $minstandingguests, $maxstandingguests, $count, $organizerEnabled) {
        $qb = $this->createQueryBuilder("v");
        if ($count) {
            $qb->select("COUNT(DISTINCT v)");
        } else {
            $qb->select("DISTINCT v");
        }
        if ($organizer !== "all" || $organizerEnabled !== "all") {
            $qb->leftJoin("v.organizer", "organizer");
        }
        if ($organizer !== "all") {
            $qb->andWhere("organizer.slug = :organizer")->setParameter("organizer", $organizer);
        }
        if ($organizerEnabled !== "all") {
            $qb->leftJoin("organizer.user", "user");
            $qb->andWhere("user.enabled = :userEnabled")->setParameter("userEnabled", $organizerEnabled);
        }
        if ($keyword !== "all" || $slug !== "all") {
            $qb->join("v.translations", "translations");
        }
        if ($country !== "all") {
            $qb->join("v.country", "country");
            $qb->join("country.translations", "countrytranslations");
            $qb->andWhere("countrytranslations.slug = :country")->setParameter("country", $country);
        }
        if ($venuetypes !== "all") {
            $qb->join("v.type", "venuetype");
            $qb->join("venuetype.translations", "venuetypetranslations");
            $i = 0;
            $orX = $qb->expr()->orX();
            foreach ($venuetypes as $venuetype) {
                $orX->add('venuetypetranslations.slug = :venuetypeslug' . $i);
                $qb->setParameter("venuetypeslug" . $i, $venuetype);
                $i++;
            }
            $qb->andWhere($orX);
        }
        if ($hidden !== "all") {
            $qb->andWhere("v.hidden = :hidden")->setParameter("hidden", $hidden);
        }
        if ($keyword !== "all") {
            $qb->andWhere("translations.name LIKE :keyword or :keyword LIKE translations.name or translations.description LIKE :keyword or :keyword LIKE translations.description")->setParameter("keyword", "%" . $keyword . "%");
        }
        if ($directory !== "all") {
            $qb->andWhere("v.listedondirectory = :listedondirectory")->setParameter("listedondirectory", $directory);
        }
        if ($slug !== "all") {
            $qb->andWhere("translations.slug = :slug")->setParameter("slug", $slug);
        }
        if ($limit !== "all") {
            $qb->setMaxResults($limit);
        }
        if ($minseatedguests !== "all") {
            $qb->andWhere("v.seatedguests >= :minseatedguests")->setParameter("minseatedguests", $minseatedguests);
        }
        if ($maxseatedguests !== "all") {
            $qb->andWhere("v.seatedguests <= :maxseatedguests")->setParameter("maxseatedguests", $maxseatedguests);
        }
        if ($minstandingguests !== "all") {
            $qb->andWhere("v.standingguests >= :minstandingguests")->setParameter("minstandingguests", $minstandingguests);
        }
        if ($maxseatedguests !== "all") {
            $qb->andWhere("v.standingguests <= :maxstandingguests")->setParameter("maxstandingguests", $maxstandingguests);
        }
        $qb->orderBy("v.createdAt", "DESC");
        return $qb;
    }

}
