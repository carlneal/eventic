<?php

namespace App\Repository;

use App\Entity\EventImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventImage[]    findAll()
 * @method EventImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventImageRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, EventImage::class);
    }

    // /**
    //  * @return EventImage[] Returns an array of EventImage objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('e')
      ->andWhere('e.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('e.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?EventImage
      {
      return $this->createQueryBuilder('e')
      ->andWhere('e.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
}
