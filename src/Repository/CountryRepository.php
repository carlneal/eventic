<?php

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CountryRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Country::class);
    }

    public function getCountries($id, $hidden, $keyword, $isocode, $slug, $limit, $sort, $order) {
        $qb = $this->createQueryBuilder("c");
        $qb->select("DISTINCT c");
        $qb->join("c.translations", "translations");
        if ($id !== "all") {
            $qb->andWhere("c.id = :id")->setParameter("id", $id);
        }
        if ($hidden !== "all") {
            $qb->andWhere("c.hidden = :hidden")->setParameter("hidden", $hidden);
        }
        if ($keyword !== "all") {
            $qb->andWhere("translations.name LIKE :keyword or :keyword LIKE translations.name")->setParameter("keyword", "%" . $keyword . "%");
        }
        if ($isocode !== "all") {
            $qb->andWhere("c.code = :isocode")->setParameter("isocode", $isocode);
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
