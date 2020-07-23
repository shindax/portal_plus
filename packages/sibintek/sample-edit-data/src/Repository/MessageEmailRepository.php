<?php

namespace Sibintek\ConsentPersData\Repository;

use Sibintek\ConsentPersData\Entity\MessageEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sibintek\ConsentPersData\Pagination\Paginator;

/**
 * @method MessageEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageEmail[]    findAll()
 * @method MessageEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageEmail::class);
    }

    public function findLatest(int $page = 1, int $pageSize = 10, int $sort = null, $find): Paginator
    {
        $qb = $this->createQueryBuilder('m')
            ->addSelect('a')
            ->leftJoin('m.sender', 'a')
        ;

        if ($find['subject']) {
            $qb->andWhere( $qb->expr()->like('m.subject', $qb->expr()->literal('%'.$find['subject'].'%')));
        }
        if ($find['body']) {
            $qb->andWhere( $qb->expr()->like('m.body', $qb->expr()->literal('%'.$find['body'].'%')));
        }
        if ($find['sender']) {
            $qb->andWhere( $qb->expr()->like('a.name', $qb->expr()->literal('%'.$find['sender'].'%')));
        }
        if ($find['fdatereceipt']) {
            $qb->andWhere( 'm.dateTimeReceived >= :fdatereceipt');
            $qb->setParameter('fdatereceipt', $find['fdatereceipt']);
        }
        if ($find['ldatereceipt']) {
            $qb->andWhere( 'm.dateTimeReceived <= :ldatereceipt');
            $qb->setParameter('ldatereceipt', $find['ldatereceipt']);
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
        $sortcol = array(1=>'m.subject', 2=>'m.body', 3=>'a.name', 4=>'m.datereceipt', 5=>'m.datesent');
        if ($sort) {
            $qb->addOrderBy($sortcol[abs($sort)], $direction);
        }

        return (new Paginator($qb, $pageSize))->paginate($page);
    }

    // /**
    //  * @return MessageEmail[] Returns an array of MessageEmail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageEmail
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
