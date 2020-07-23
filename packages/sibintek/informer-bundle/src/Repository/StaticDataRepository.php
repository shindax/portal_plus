<?php

namespace Sibintek\InformerBundle\Repository;

use Sibintek\InformerBundle\Entity\StaticData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 *
 *
 */
class StaticDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StaticData::class);
    }

    public function findByType($value): ?StaticData
    {
//        $qb =  $this->createQueryBuilder('s')
//            ->andWhere('s.type like :val')
//            ->setParameter('val', '%'.$value.'%')
//            ->getQuery();
//            var_dump($qb->getOneOrNullResult());
//        die;

        return $this->createQueryBuilder('s')
            ->andWhere('s.type like :val')
            ->setParameter('val', '%'.$value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
