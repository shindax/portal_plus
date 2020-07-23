<?php

namespace App\Repository;

use App\Entity\OrgUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrgUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrgUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrgUser[]    findAll()
 * @method OrgUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrgUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrgUser::class);
    }

    // /**
    //  * @return OrgUser[] Returns an array of OrgUser objects
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
    public function findOneBySomeField($value): ?OrgUser
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
