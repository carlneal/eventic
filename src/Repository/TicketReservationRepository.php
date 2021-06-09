<?php

namespace App\Repository;

use App\Entity\TicketReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TicketReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketReservation[]    findAll()
 * @method TicketReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketReservationRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, TicketReservation::class);
    }

    // /**
    //  * @return TicketReservation[] Returns an array of TicketReservation objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('t')
      ->andWhere('t.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('t.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?TicketReservation
      {
      return $this->createQueryBuilder('t')
      ->andWhere('t.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
}
