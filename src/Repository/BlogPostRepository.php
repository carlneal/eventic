<?php

namespace App\Repository;

use App\Entity\BlogPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BlogPostRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, BlogPost::class);
    }

    public function getBlogPosts($selecttags, $hidden, $keyword, $slug, $category, $limit, $sort, $order, $otherthan) {
        $qb = $this->createQueryBuilder("b");
        if ($keyword !== "all" || $slug !== "all" || $selecttags === true) {
            $qb->join("b.translations", "translations");
        }
        if (!$selecttags) {
            $qb->select("DISTINCT b");
            if ($hidden !== "all") {
                $qb->andWhere("b.hidden = :hidden")->setParameter("hidden", $hidden);
            }
            if ($keyword !== "all") {
                $qb->andWhere("translations.name LIKE :keyword or :keyword LIKE translations.name or :keyword LIKE translations.content or translations.content LIKE :keyword or :keyword LIKE translations.tags or translations.tags LIKE :keyword")->setParameter("keyword", "%" . $keyword . "%");
            }
            if ($slug !== "all") {
                $qb->andWhere("translations.slug = :slug")->setParameter("slug", $slug);
            }
            if ($category !== "all") {
                $qb->leftJoin("b.category", "category");
                $qb->leftJoin("category.translations", "categorytranslations");
                $qb->andWhere("categorytranslations.slug = :category")->setParameter("category", $category);
            }
            if ($limit !== "all") {
                $qb->setMaxResults($limit);
            }
            if ($otherthan !== "all") {
                $qb->andWhere("b.id != :otherthan")->setParameter("otherthan", $otherthan);
            }
            $qb->orderBy("b." . $sort, $order);
        } else {
            $qb->select("SUBSTRING_INDEX(GROUP_CONCAT(translations.tags SEPARATOR ','), ',', 8)");
        }
        return $qb;
    }

}
