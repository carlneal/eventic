<?php

namespace App\Repository;

use App\Entity\PaymentGateway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PaymentGatewayRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, PaymentGateway::class);
    }

    public function getPaymentGateways($organizer, $enabled, $gatewayFactoryName, $slug, $sort, $order, $organizerPayoutPaypalEnabled, $organizerPayoutStripeEnabled) {

        $qb = $this->createQueryBuilder("p");
        $qb->select("DISTINCT p");
        if ($organizer !== null) {
            $qb->leftJoin("p.organizer", "organizer");
            $qb->andWhere("organizer.slug = :organizer")->setParameter("organizer", $organizer);
            if ($organizerPayoutPaypalEnabled == "no") {
                $qb->andWhere("p.factoryName != 'paypal_rest'");
            }
            if ($organizerPayoutStripeEnabled == "no") {
                $qb->andWhere("p.gatewayName != 'Stripe'");
            }
        } else {
            $qb->andWhere("p.organizer IS NULL");
        }
        if ($enabled !== "all") {
            $qb->andWhere("p.enabled = :enabled")->setParameter("enabled", $enabled);
        }
        if ($gatewayFactoryName !== "all") {
            $qb->andWhere("p.factoryName = :gatewayFactoryName")->setParameter("gatewayFactoryName", $gatewayFactoryName);
        }
        if ($slug !== "all") {
            $qb->andWhere("p.slug = :slug")->setParameter("slug", $slug);
        }
        $qb->orderBy("p." . $sort, $order);
        // Always exclude the Point of sale payment gateway (offline) and the payment gateway that handles free orders (orders with total amount = 0)
        $qb->andWhere("p.slug != :pointOfSale")->setParameter("pointOfSale", "point-of-sale");
        $qb->andWhere("p.slug != :free")->setParameter("free", "free");
        return $qb;
    }

}
