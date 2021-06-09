<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReviewRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Review::class);
    }

    public function getReviews($keyword, $slug, $user, $event, $organizer, $visible, $rating, $minrating, $maxrating, $limit, $count, $sort, $order) {
        $qb = $this->createQueryBuilder("r");
        if ($count) {
            $qb->select("COUNT(DISTINCT r)");
        } else {
            $qb->select("DISTINCT r");
        }
        if ($keyword !== "all") {
            $qb->andWhere("r.headline LIKE :keyword or :keyword LIKE r.headline or r.details LIKE :keyword or :keyword LIKE r.details")->setParameter("keyword", "%" . $keyword . "%");
        }
        if ($slug !== "all") {
            $qb->andWhere("r.slug = :slug")->setParameter("slug", $slug);
        }
        if ($user !== "all") {
            $qb->leftJoin("r.user", "user");
            $qb->andWhere("user.slug = :user")->setParameter("user", $user);
        }
        if ($event !== "all" || $organizer !== "all") {
            $qb->leftJoin("r.event", "event");
        }

        if ($event !== "all") {
            $qb->leftJoin("event.translations", "eventtranslations");
            $qb->andWhere("eventtranslations.slug = :event")->setParameter("event", $event);
        }
        if ($organizer !== "all") {
            $qb->leftJoin("event.organizer", "organizer");
            $qb->andWhere("organizer.slug = :organizer")->setParameter("organizer", $organizer);
        }
        if ($visible !== "all") {
            $qb->andWhere("r.visible = :visible")->setParameter("visible", $visible);
        }
        if ($rating !== "all") {
            $qb->andWhere("r.rating = :rating")->setParameter("rating", $rating);
        }
        if ($minrating !== "all") {
            $qb->andWhere("r.rating >= :minrating")->setParameter("minrating", $minrating);
        }
        if ($maxrating !== "all") {
            $qb->andWhere("r.rating <= :maxrating")->setParameter("maxrating", $maxrating);
        }
        if ($limit !== "all") {
            $qb->setMaxResults($limit);
        }
        if ($sort) {
            $qb->orderBy("r." . $sort, $order);
        }
        return $qb;
    }

}
