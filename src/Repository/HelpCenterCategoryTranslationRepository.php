<?php

namespace App\Repository;

use App\Entity\HelpCenterCategoryTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HelpCenterCategoryTranslationRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, HelpCenterCategoryTranslation::class);
    }

}
