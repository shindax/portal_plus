<?php

namespace App\Repository;

use App\Entity\RnPhotos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RnPhotos|null find($id, $lockMode = null, $lockVersion = null)
 * @method RnPhotos|null findOneBy(array $criteria, array $orderBy = null)
 * @method RnPhotos[]    findAll()
 * @method RnPhotos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RnPhotosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RnPhotos::class);
    }

    // /**
    //  * @return RnPhotos[] Returns an array of RnPhotos objects
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
    public function findOneBySomeField($value): ?RnPhotos
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
