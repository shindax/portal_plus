<?php

namespace App\Repository;

use App\Entity\RnContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RnContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method RnContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method RnContent[]    findAll()
 * @method RnContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RnContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RnContent::class);
    }

    // /**
    //  * @return RnContent[] Returns an array of RnContent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RnContent
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
