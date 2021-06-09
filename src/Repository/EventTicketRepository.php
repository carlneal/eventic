<?php

namespace App\Repository;

use App\Entity\EventTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventTicketRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, EventTicket::class);
    }

    public function getEventTickets($reference, $organizer, $event, $eventdate, $limit) {
        $qb = $this->createQueryBuilder("e");
        $qb->select("DISTINCT e");
        if ($reference !== "all") {
            $qb->andWhere("e.reference = :reference")->setParameter("reference", $reference);
        }
        if ($event !== "all" || $organizer !== "all" || $eventdate !== "all") {
            $qb->leftJoin("e.eventdate", "eventdate");
        }
        if ($event !== "all" || $organizer !== "all") {
            $qb->leftJoin("eventdate.event", "event");
        }
        if ($organizer !== "all") {
            $qb->leftJoin("event.organizer", "organizer");
            $qb->andWhere("organizer.slug = :organizer")->setParameter("organizer", $organizer);
        }
        if ($event !== "all") {
            $qb->leftJoin("event.translations", "eventtranslations");
            $qb->andWhere("eventtranslations.slug = :event")->setParameter("event", $event);
        }
        if ($eventdate !== "all") {
            $qb->andWhere("eventdate.reference = :eventdate")->setParameter("eventdate", $eventdate);
        }
        $qb->orderBy("e.id", "ASC");
        if ($limit !== "all") {
            $qb->setMaxResults($limit);
        }
        return $qb;
    }

}
