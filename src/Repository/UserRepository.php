<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, User::class);
    }

    public function getUsers($role, $keyword, $createdbyorganizerslug, $organizername, $organizerslug, $username, $email, $firstname, $lastname, $enabled, $countryslug, $slug, $followedby, $hasboughtticketforEvent, $hasboughtticketforOrganizer, $apiKey, $isOnHomepageSlider, $limit, $sort, $order, $count) {
        $qb = $this->createQueryBuilder("u");
        if ($count) {
            $qb->select("COUNT(DISTINCT u)");
        } else {
            $qb->select("DISTINCT u");
        }

        if ($role !== "all") {
            $qb->andWhere("u.roles LIKE :role")->setParameter("role", "%ROLE_" . strtoupper($role) . "%");
            if ($role == "pointofsale" && $createdbyorganizerslug !== "all") {
                $qb->leftJoin("u.pointofsale", "pointofsale");
                $qb->leftJoin("pointofsale.organizer", "pointofsaleorganizer");
                $qb->andWhere("pointofsaleorganizer.slug = :pointofsalecreatedbyorganizerslug");
                $qb->setParameter("pointofsalecreatedbyorganizerslug", $createdbyorganizerslug);
            } else if ($role == "scanner" && $createdbyorganizerslug !== "all") {
                $qb->leftJoin("u.scanner", "scanner");
                $qb->leftJoin("scanner.organizer", "scannerorganizer");
                $qb->andWhere("scannerorganizer.slug = :scannercreatedbyorganizerslug");
                $qb->setParameter("scannercreatedbyorganizerslug", $createdbyorganizerslug);
            }
        }
        if ($keyword !== "all") {
            $qb->andWhere("u.username LIKE :keyword or :keyword LIKE u.username or u.email LIKE :keyword or :keyword LIKE u.email or u.firstname LIKE :keyword or :keyword LIKE u.firstname or u.lastname LIKE :keyword or :keyword LIKE u.lastname")->setParameter("keyword", "%" . $keyword . "%");
        }
        if ($organizername !== "all" || $organizerslug || $followedby) {
            $qb->leftJoin("u.organizer", "organizer");
        }
        if ($organizername !== "all") {
            $qb->andWhere("organizer.name LIKE :organizername or :organizername LIKE organizer.name")->setParameter("organizername", "%" . $organizername . "%");
        }
        if ($organizerslug !== "all") {
            $qb->andWhere("organizer.slug = :organizerslug")->setParameter("organizerslug", $organizerslug);
        }
        if ($username !== "all") {
            $qb->andWhere("u.username LIKE :username or :username LIKE u.username")->setParameter("username", "%" . $username . "%");
        }
        if ($email !== "all") {
            $qb->andWhere("u.email LIKE :email or :email LIKE u.email")->setParameter("email", "%" . $email . "%");
        }
        if ($firstname !== "all") {
            $qb->andWhere("u.firstname LIKE :firstname or :firstname LIKE u.firstname")->setParameter("firstname", "%" . $firstname . "%");
        }
        if ($lastname !== "all") {
            $qb->andWhere("u.lastname LIKE :lastname or :lastname LIKE u.lastname")->setParameter("lastname", "%" . $lastname . "%");
        }
        if ($enabled !== "all") {
            $qb->andWhere("u.enabled = :enabled")->setParameter("enabled", $enabled);
        }
        if ($countryslug !== "all") {
            $qb->leftJoin("u.country", "country");
            $qb->join("country.translations", "countrytranslations");
            $qb->andWhere("countrytranslations.slug = :countryslug")->setParameter("countryslug", $countryslug);
        }
        if ($slug !== "all") {
            $qb->andWhere("u.slug = :slug")->setParameter("slug", $slug);
        }
        if ($followedby !== "all") {
            $qb->andWhere(":followedby MEMBER OF organizer.followedby")->setParameter("followedby", $followedby);
        }

        if ($hasboughtticketforEvent !== "all" || $hasboughtticketforOrganizer != "all") {
            $qb->join("u.orders", "orders");
            $qb->join("orders.orderelements", "orderelements");
            $qb->join("orderelements.eventticket", "eventticket");
            $qb->join("eventticket.eventdate", "eventdate");
            $qb->join("eventdate.event", "event");
        }
        if ($hasboughtticketforEvent !== "all") {
            $qb->join("event.translations", "eventtranslations");
            $qb->andWhere("orders.status = :statuspaid")->setParameter("statuspaid", 1);
            $qb->andWhere("eventtranslations.slug = :hasboughtticketforevent")->setParameter("hasboughtticketforevent", $hasboughtticketforEvent);
        }
        if ($hasboughtticketforOrganizer !== "all") {
            $qb->join("event.organizer", "eventOrganizer");
            $qb->andWhere("eventOrganizer.slug = :hasboughtticketfororganizer")->setParameter("hasboughtticketfororganizer", $hasboughtticketforOrganizer);
        }
        if ($apiKey !== "all") {
            $qb->andWhere("u.apiKey = :apiKey")->setParameter("apiKey", $apiKey);
        }
        if ($isOnHomepageSlider === true) {
            $qb->andWhere("u.isorganizeronhomepageslider IS NOT NULL");
        }
        if ($limit !== "all") {
            $qb->setMaxResults($limit);
        }
        if ($hasboughtticketforEvent !== "all") {
            $qb->orderBy("orders.createdAt", "DESC");
        } else {
            $qb->orderBy($sort, $order);
        }
        $qb->andWhere("u.slug != :administrator")->setParameter("administrator", "administrator");
        return $qb;
    }

}
