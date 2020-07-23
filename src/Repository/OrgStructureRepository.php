<?php

namespace App\Repository;

use App\Entity\OrgStructure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrgStructure|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrgStructure|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrgStructure[]    findAll()
 * @method OrgStructure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrgStructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrgStructure::class);
    }

    // /**
    //  * @return OrgStructure[] Returns an array of OrgStructure objects
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
    public function findOneBySomeField($value): ?OrgStructure
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
