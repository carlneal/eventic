<?php

namespace App\Repository;

use App\Entity\PayoutRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PayoutRequestRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, PayoutRequest::class);
    }

    public function getPayoutRequests($reference, $eventdate, $organizer, $datefrom, $dateto, $status, $sort, $order, $limit, $count) {
        $qb = $this->createQueryBuilder("p");
        if ($count) {
            $qb->select("COUNT(DISTINCT p)");
        } else {
            $qb->select("DISTINCT p");
        }
        if ($reference !== "all") {
            $qb->andWhere("p.reference = :reference")->setParameter("reference", $reference);
        }
        if ($eventdate !== "all") {
            $qb->leftJoin("p.eventDate", "eventDate");
            $qb->andWhere("eventDate.reference = :eventDate")->setParameter("eventDate", $eventdate);
        }
        if ($organizer !== "all") {
            $qb->leftJoin("p.organizer", "organizer");
            $qb->andWhere("organizer.slug = :organizer")->setParameter("organizer", $organizer);
        }
        if ($datefrom !== "all") {
            $qb->andWhere("p.createdAt >= :datefrom")->setParameter("datefrom", $datefrom);
        }
        if ($dateto !== "all") {
            $qb->andWhere("p.createdAt <= :dateto")->setParameter("dateto", $dateto);
        }
        if ($status !== "all") {
            $qb->andWhere("p.status = :status")->setParameter("status", $status);
        }
        if ($limit !== "all") {
            $qb->setMaxResults($limit);
        }
        if ($sort) {
            $qb->orderBy("p." . $sort, $order);
        }

        return $qb;
    }

}
