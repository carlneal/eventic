<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Order::class);
    }

    public function getOrders($status, $user, $organizer, $event, $eventDate, $eventTicket, $reference, $upcomingtickets, $datefrom, $dateto, $paymentgateway, $sort, $order, $limit, $count, $ordersQuantityByDateStat, $sumOrderElements) {
        $qb = $this->createQueryBuilder("o");
        if ($count) {
            $qb->select("COUNT(DISTINCT o)");
        } elseif ($ordersQuantityByDateStat) {
            $qb->select("SUM(orderelement.quantity), DATE(o.createdAt) as dateCreatedAt");
            $qb->groupBy("dateCreatedAt");
        } elseif ($sumOrderElements) {
            $qb->select("SUM(orderelement.quantity)");
        } else {
            $qb->select("DISTINCT o");
        }
        if ($status !== "all") {
            $qb->andWhere("o.status = :status")->setParameter("status", $status);
        }
        if ($user !== "all") {
            $qb->leftJoin("o.user", "user");
            $qb->andWhere("user.slug = :user")->setParameter("user", $user);
        }
        if ($organizer !== "all" || $upcomingtickets !== "all" || $event !== "all" || $eventDate !== "all" || $eventTicket !== "all" || $ordersQuantityByDateStat || $sumOrderElements) {
            $qb->leftJoin("o.orderelements", "orderelement");
            $qb->leftJoin("orderelement.eventticket", "eventticket");
            $qb->leftJoin("eventticket.eventdate", "eventdate");
        }
        if ($organizer !== "all" || $event !== "all") {
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
        if ($eventDate !== "all") {
            $qb->andWhere("eventdate.reference = :eventdate")->setParameter("eventdate", $eventDate);
        }
        if ($eventTicket !== "all") {
            $qb->andWhere("eventticket.reference = :eventticket")->setParameter("eventticket", $eventTicket);
        }
        if ($reference !== "all") {
            $qb->andWhere("o.reference = :reference")->setParameter("reference", $reference);
        }
        if ($datefrom !== "all") {
            $qb->andWhere("o.createdAt >= :datefrom")->setParameter("datefrom", $datefrom);
        }
        if ($dateto !== "all") {
            $qb->andWhere("o.createdAt <= :dateto")->setParameter("dateto", $dateto);
        }
        if ($paymentgateway !== "all") {
            $qb->leftJoin("o.paymentgateway", "paymentgateway");
            $qb->andWhere("paymentgateway.slug = :paymentgateway")->setParameter("paymentgateway", $paymentgateway);
        }
        if ($upcomingtickets !== "all") {
            if ($upcomingtickets === 1) {
                $qb->andWhere("eventdate.startdate >= NOW()");
            } else if ($upcomingtickets === 0) {
                $qb->andWhere("eventdate.startdate < NOW()");
            }
        }
        if ($limit !== "all") {
            $qb->setMaxResults($limit);
        }
        if ($sort) {
            $qb->orderBy("o." . $sort, $order);
        }
        return $qb;
    }

}
