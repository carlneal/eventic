<?php

namespace App\Repository;

use App\Entity\BlogPostCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BlogPostCategoryRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, BlogPostCategory::class);
    }

    public function getBlogPostCategories($hidden, $keyword, $slug, $limit, $order, $sort) {
        $qb = $this->createQueryBuilder("b");
        $qb->select("DISTINCT b");
        $qb->join("b.translations", "translations");
        if ($hidden !== "all") {
            $qb->andWhere("b.hidden = :hidden")->setParameter("hidden", $hidden);
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
        if ($order == "blogpostscount") {
            $qb->leftJoin("b.blogposts", "blogposts");
            $qb->addSelect("COUNT(blogposts.id) AS HIDDEN blogpostscount");
            $qb->orderBy("blogpostscount", "DESC");
            $qb->groupBy("b.id");
        } else {
            $qb->orderBy($order, $sort);
        }
        return $qb;
    }

}
