<?php

namespace App\Repository;

use App\Entity\Amenity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AmenityRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Amenity::class);
    }

    public function getAmenities($hidden, $keyword, $slug, $limit, $sort, $order) {
        $qb = $this->createQueryBuilder("a");
        $qb->select("DISTINCT a");
        $qb->join("a.translations", "translations");
        if ($hidden !== "all") {
            $qb->andWhere("a.hidden = :hidden")->setParameter("hidden", $hidden);
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
        $qb->orderBy($sort, $order);
        return $qb;
    }

}
