<?php

namespace Sibintek\ConsentPersData\Repository;

use Sibintek\ConsentPersData\Entity\Feedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sibintek\ConsentPersData\Pagination\Paginator;

/**
 * @method Feedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    public function findLatest(int $page = 1, int $pageSize = 10, int $sort = null, $find): Paginator
    {
        $qb = $this->createQueryBuilder('m')
        ;

        if ($find['subject']) {
            $qb->andWhere( $qb->expr()->like('m.subject', $qb->expr()->literal('%'.$find['subject'].'%')));
        }
        if ($find['body']) {
            $qb->andWhere( $qb->expr()->like('m.body', $qb->expr()->literal('%'.$find['body'].'%')));
        }
        if ($find['email']) {
            $qb->andWhere( $qb->expr()->like('m.emailAddresses', $qb->expr()->literal('%'.$find['email'].'%')));
        }
        if ($find['fdatesent']) {
            $qb->andWhere( 'm.dateTimeSent >= :fdatesent');
            $qb->setParameter('fdatesent', $find['fdatesent']);
        }
        if ($find['ldatesent']) {
            $qb->andWhere( 'm.dateTimeSent <= :ldatesent');
            $qb->setParameter('ldatesent', $find['ldatesent']);
        }

        $direction = ($sort < 0 )?'desc':'asc';
        $sortcol = array(1=>'m.emailAddresses', 2=>'m.subject', 3=>'m.dateTimeSent');
        if ($sort) {
            $qb->addOrderBy($sortcol[abs($sort)], $direction);
        }

        return (new Paginator($qb, $pageSize))->paginate($page);
    }

    // /**
    //  * @return Feedback[] Returns an array of Feedback objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Feedback
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
