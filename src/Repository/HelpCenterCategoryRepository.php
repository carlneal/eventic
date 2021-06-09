<?php

namespace App\Repository;

use App\Entity\HelpCenterCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HelpCenterCategoryRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, HelpCenterCategory::class);
    }

    public function getHelpCenterCategories($parent, $hidden, $keyword, $slug, $limit, $order, $sort) {
        $qb = $this->createQueryBuilder("c");
        $qb->select("DISTINCT c");
        $qb->join("c.translations", "translations");
        if ($parent !== "all") {
            if ($parent === "none") {
                $qb->andWhere("c.parent IS NULL");
            } else if ($parent === "notnull") {
                $qb->andWhere("c.parent IS NOT NULL");
            } else {
                $qb->leftJoin("c.parent", "parentcategory");
                $qb->leftJoin("parentcategory.translations", "parentcategorytranslations");
                $qb->andWhere("parentcategorytranslations.slug = :parentcategory");
                $qb->setParameter("parentcategory", $parent);
            }
        }
        if ($hidden !== "all") {
            $qb->andWhere("c.hidden = :hidden")->setParameter("hidden", $hidden);
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

        if ($order == "articlescount") {
            $qb->leftJoin("c.articles", "articles");
            $qb->addSelect("COUNT(articles.id) AS HIDDEN articlescount");
            $qb->orderBy("articlescount", "DESC");
            $qb->groupBy("c.id");
        } else {
            $qb->orderBy($order, $sort);
        }
        return $qb;
    }

}
