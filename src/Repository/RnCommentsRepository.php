<?php

namespace App\Repository;

use App\Entity\RnComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RnComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method RnComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method RnComments[]    findAll()
 * @method RnComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RnCommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RnComments::class);
    }

    // /**
    //  * @return RnComments[] Returns an array of RnComments objects
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
    public function findOneBySomeField($value): ?RnComments
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
