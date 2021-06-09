<?php

namespace App\Repository;

use App\Entity\HelpCenterArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HelpCenterArticleRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, HelpCenterArticle::class);
    }

    public function getHelpCenterArticles($selecttags, $hidden, $featured, $keyword, $slug, $category, $limit, $sort, $order, $otherthan) {
        $qb = $this->createQueryBuilder("a");
        if ($keyword !== "all" || $slug !== "all" || $otherthan !== "all" || $selecttags) {
            $qb->join("a.translations", "translations");
        }
        if (!$selecttags) {
            $qb->select("DISTINCT a");
            if ($hidden !== "all") {
                $qb->andWhere("a.hidden = :hidden")->setParameter("hidden", $hidden);
            }
            if ($featured !== "all") {
                $qb->andWhere("a.featured = :featured")->setParameter("featured", $featured);
            }
            if ($keyword !== "all") {
                $qb->andWhere("translations.title LIKE :keyword or :keyword LIKE translations.title or :keyword LIKE translations.content or translations.content LIKE :keyword or :keyword LIKE translations.tags or translations.tags LIKE :keyword")->setParameter("keyword", "%" . $keyword . "%");
            }
            if ($slug !== "all") {
                $qb->andWhere("translations.slug = :slug")->setParameter("slug", $slug);
            }
            if ($category !== "all") {
                $qb->leftJoin("a.category", "category");
                $qb->leftJoin("category.translations", "categorytranslations");
                $qb->andWhere("categorytranslations.slug = :category")->setParameter("category", $category);
            }
            if ($limit !== "all") {
                $qb->setMaxResults($limit);
            }
            if ($otherthan !== "all") {
                $qb->andWhere("translations.slug != :otherthan")->setParameter("otherthan", $otherthan);
            }
            $qb->orderBy("a." . $sort, $order);
        } else {
            $qb->select("SUBSTRING_INDEX(GROUP_CONCAT(translations.tags SEPARATOR ','), ',', 8)");
        }
        return $qb;
    }

}
