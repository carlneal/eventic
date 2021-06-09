<?php

namespace App\Repository;

use App\Entity\AudienceTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AudienceTranslationRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, AudienceTranslation::class);
    }

}
