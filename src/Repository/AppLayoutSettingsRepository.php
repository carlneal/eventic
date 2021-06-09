<?php

namespace App\Repository;

use App\Entity\AppLayoutSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AppLayoutSettingsRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, AppLayoutSettings::class);
    }

}
