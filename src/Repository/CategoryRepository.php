<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Category::class);
    }

    public function getCategories($hidden, $keyword, $slug, $featured, $limit, $sort, $order) {
        $qb = $this->createQueryBuilder("c");
        $qb->select("DISTINCT c");
        $qb->join("c.translations", "translations");
        if ($hidden !== "all") {
            $qb->andWhere("c.hidden = :hidden")->setParameter("hidden", $hidden);
        }
        if ($keyword !== "all") {
            $qb->andWhere("translations.name LIKE :keyword or :keyword LIKE translations.name")->setParameter("keyword", "%" . $keyword . "%");
        }
        if ($slug !== "all") {
            $qb->andWhere("translations.slug = :slug")->setParameter("slug", $slug);
        }
        if ($featured !== "all") {
            $qb->andWhere("c.featured = :featured")->setParameter("featured", $featured);
            if ($featured === true) {
                $qb->orderBy("c.featuredorder", "ASC");
            }
        }
        if ($limit !== "all") {
            $qb->setMaxResults($limit);
        }
        $qb->orderBy($sort, $order);
        return $qb;
    }

}
