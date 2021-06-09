<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CurrencyRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Currency::class);
    }

    public function getCurrencies($ccy, $symbol) {
        $qb = $this->createQueryBuilder("c");
        $qb->select("DISTINCT c");
        if ($ccy !== "all") {
            $qb->andWhere("c.ccy = :ccy")->setParameter("ccy", $ccy);
        }
        if ($symbol !== "all") {
            $qb->andWhere("c.symbol = :symbol")->setParameter("symbol", $symbol);
        }
        return $qb;
    }

}
