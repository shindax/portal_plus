<?php

namespace Sibintek\InformerBundle\Repository;

use Sibintek\InformerBundle\Entity\Weather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 *
 *
 */
class WeatherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weather::class);
    }

    public function findByPlace($value): ?Weather
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
