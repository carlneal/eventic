<?php

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PaymentRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Payment::class);
    }

    public function getPayments($number) {
        $qb = $this->createQueryBuilder("p");
        $qb->select("DISTINCT p");
        if ($number !== "all") {
            $qb->andWhere("p.number = :number")->setParameter("number", $number);
        }
        return $qb;
    }

}
