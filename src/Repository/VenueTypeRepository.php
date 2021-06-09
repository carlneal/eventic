<?php

namespace App\Repository;

use App\Entity\VenueType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VenueTypeRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, VenueType::class);
    }

    public function getVenuesTypes($hidden, $keyword, $slug, $limit, $sort, $order, $hasvenues) {
        $qb = $this->createQueryBuilder("v");
        $qb->select("DISTINCT v");
        $qb->addSelect("COUNT(DISTINCT v) as HIDDEN venuescount");
        $qb->join("v.translations", "translations");
        if ($hidden !== "all") {
            $qb->andWhere("v.hidden = :hidden")->setParameter("hidden", $hidden);
        }
        if ($keyword !== "all") {
            $qb->andWhere("translations.name LIKE :keyword or :keyword LIKE translations.name")->setParameter("keyword", "%" . $keyword . "%");
        }
        if ($slug !== "all") {
            $qb->andWhere("translations.slug = :slug")->setParameter("slug", $slug);
        }
        if ($limit !== "all") {
            $qb->setMaxResults($limit);
        }
        if ($hasvenues === true || $hasvenues === 1) {
            $qb->join("v.venues", "venues");
        }
        $qb->orderBy($sort, $order);
        $qb->groupBy("v");
        return $qb;
    }

}
