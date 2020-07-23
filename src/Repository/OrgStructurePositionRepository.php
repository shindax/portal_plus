<?php

namespace App\Repository;

use App\Entity\OrgStructurePosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrgStructurePosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrgStructurePosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrgStructurePosition[]    findAll()
 * @method OrgStructurePosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrgStructurePositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrgStructurePosition::class);
    }

    // /**
    //  * @return OrgStructurePosition[] Returns an array of OrgStructurePosition objects
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
    public function findOneBySomeField($value): ?OrgStructurePosition
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
