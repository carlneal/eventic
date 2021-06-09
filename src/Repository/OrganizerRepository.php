<?php

namespace App\Repository;

use App\Entity\Organizer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Organizer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organizer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organizer[]    findAll()
 * @method Organizer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizerRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Organizer::class);
    }

    // /**
    //  * @return Organizer[] Returns an array of Organizer objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('o')
      ->andWhere('o.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('o.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?Organizer
      {
      return $this->createQueryBuilder('o')
      ->andWhere('o.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
}
