<?php

namespace App\Repository;

use App\Entity\UnionOrgUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UnionOrgUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnionOrgUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnionOrgUser[]    findAll()
 * @method UnionOrgUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnionOrgUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnionOrgUser::class);
    }

    // /**
    //  * @return UnionOrgUser[] Returns an array of UnionOrgUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UnionOrgUser
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
