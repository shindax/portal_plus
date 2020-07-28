<?php

namespace Sibintek\NewsBundle\Repository;

use Sibintek\NewsBundle\Entity\OrgNews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrgNews|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrgNews|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrgNews[]    findAll()
 * @method OrgNews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrgNewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrgNews::class);
    }

    // /**
    //  * @return OrgNews[] Returns an array of OrgNews objects
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
    public function findOneBySomeField($value): ?OrgNews
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
