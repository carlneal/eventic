<?php

namespace App\Repository;

use App\Entity\HelpCenterArticleTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HelpCenterArticleTranslationRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, HelpCenterArticleTranslation::class);
    }

}
