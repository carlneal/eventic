<?php

namespace App\Repository;

use App\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LanguageRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Language::class);
    }

    public function getLanguages($hidden, $keyword, $slug, $limit, $sort, $order) {
        $qb = $this->createQueryBuilder("l");
        $qb->select("DISTINCT l");
        $qb->join("l.translations", "translations");
        if ($hidden !== "all") {
            $qb->andWhere("l.hidden = :hidden")->setParameter("hidden", $hidden);
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
