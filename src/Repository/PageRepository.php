<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PageRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Page::class);
    }

    public function getPages($slug) {
        $qb = $this->createQueryBuilder("p");
        $qb->select("DISTINCT p");
        $qb->join("p.translations", "translations");
        if ($slug !== "all") {
            $qb->andWhere("translations.slug = :slug")->setParameter("slug", $slug);
        }
        return $qb;
    }

}
