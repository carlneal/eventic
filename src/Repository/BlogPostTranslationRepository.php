<?php

namespace App\Repository;

use App\Entity\BlogPostTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogPostTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPostTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPostTranslation[]    findAll()
 * @method BlogPostTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostTranslationRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, BlogPostTranslation::class);
    }

    // /**
    //  * @return BlogPostTranslation[] Returns an array of BlogPostTranslation objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('b')
      ->andWhere('b.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('b.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?BlogPostTranslation
      {
      return $this->createQueryBuilder('b')
      ->andWhere('b.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
}
