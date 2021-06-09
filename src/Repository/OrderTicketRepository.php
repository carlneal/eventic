<?php

namespace App\Repository;

use App\Entity\OrderTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderTicketRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, OrderTicket::class);
    }

    public function getOrderTickets($reference, $keyword, $eventDate, $checkedin) {
        $qb = $this->createQueryBuilder("t");
        $qb->select("DISTINCT t");
        if ($reference !== "all") {
            $qb->andWhere("t.reference = :reference")->setParameter("reference", $reference);
        }
        if ($keyword !== "all" || $eventDate !== "all") {
            $qb->leftJoin("t.orderelement", "orderelement");
        }
        if ($keyword !== "all") {
            $qb->leftJoin("orderelement.order", "o");
            $qb->leftJoin("o.payment", "payment");
            $qb->andWhere("t.reference LIKE :keyword OR :keyword LIKE t.reference OR o.reference LIKE :keyword OR :keyword LIKE o.reference OR payment.clientEmail LIKE :keyword OR :keyword LIKE payment.clientEmail OR payment.firstname LIKE :keyword OR :keyword LIKE payment.firstname OR payment.lastname LIKE :keyword OR :keyword LIKE payment.lastname")->setParameter("keyword", "%" . trim($keyword) . "%");
        }
        if ($eventDate !== "all") {
            $qb->leftJoin("orderelement.eventticket", "eventticket");
            $qb->leftJoin("eventticket.eventdate", "eventdate");
            $qb->andWhere("eventdate.reference = :eventdate")->setParameter("eventdate", $eventDate);
        }
        if ($checkedin !== "all") {
            if ($checkedin == "1") {
                $qb->andWhere("t.scanned = 1");
            } elseif ($checkedin == "0") {
                $qb->andWhere("t.scanned = 0");
            }
        }
        $qb->orderBy("t.createdAt", "DESC");
        return $qb;
    }

}
