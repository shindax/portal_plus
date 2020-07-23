<?php

namespace App\Repository;

use App\Entity\SysRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SysRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method SysRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method SysRole[]    findAll()
 * @method SysRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SysRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SysRole::class);
    }

    // /**
    //  * @return SysRole[] Returns an array of SysRole objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SysRole
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
