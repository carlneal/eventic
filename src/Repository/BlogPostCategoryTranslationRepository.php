<?php

namespace App\Repository;

use App\Entity\BlogPostCategoryTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogPostCategoryTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPostCategoryTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPostCategoryTranslation[]    findAll()
 * @method BlogPostCategoryTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostCategoryTranslationRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, BlogPostCategoryTranslation::class);
    }

    // /**
    //  * @return BlogPostCategoryTranslation[] Returns an array of BlogPostCategoryTranslation objects
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
      public function findOneBySomeField($value): ?BlogPostCategoryTranslation
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
