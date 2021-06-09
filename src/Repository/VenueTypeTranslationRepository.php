<?php

namespace App\Repository;

use App\Entity\VenueTypeTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VenueTypeTranslationRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, VenueTypeTranslation::class);
    }

}
