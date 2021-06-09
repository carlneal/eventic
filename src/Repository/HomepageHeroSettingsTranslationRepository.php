<?php

namespace App\Repository;

use App\Entity\HomepageHeroSettingsTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HomepageHeroSettingsTranslationRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, HomepageHeroSettingsTranslation::class);
    }

}
