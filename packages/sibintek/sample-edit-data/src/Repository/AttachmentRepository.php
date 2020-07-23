<?php

namespace Sibintek\ConsentPersData\Repository;

use Sibintek\ConsentPersData\Entity\Attachment;
use Sibintek\ConsentPersData\Entity\Candidate;
use Sibintek\ConsentPersData\Entity\EmailAddress;
use Sibintek\ConsentPersData\Entity\MessageEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sibintek\ConsentPersData\Pagination\Paginator;

/**
 * @method Attachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attachment[]    findAll()
 * @method Attachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttachmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attachment::class);
    }

    public function findLatest(int $page = 1, int $pageSize = 10, int $sort = null, $find): Paginator
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('a.id, a.path, a.originName, a.fileName')
            ->LeftJoin('a.messageEmail', 'm')
            ->addSelect('m')
            ->LeftJoin(EmailAddress::class, 'ad', 'with', 'm.sender = ad.id')
            ->addSelect('ad.name as sender, ad.id as emailaddr_id')
            ->LeftJoin(Candidate::class, 'c', 'with', 'ad.candidate = c.id')
            ->addSelect('c.lastName, c.firstName, c.patronymic, c.id as id_candidate')
        ;

        if ($find['originName']) {
            $qb->orWhere( $qb->expr()->like('a.originName', $qb->expr()->literal('%'.$find['originName'].'%')));
        }
        if ($find['emailAddress']) {
            $qb->orWhere( $qb->expr()->like('ad.name', $qb->expr()->literal('%'.$find['emailAddress'].'%')));
        }
        if ($find['fullName']) {
            $qb->orWhere( $qb->expr()->like('c.lastName', $qb->expr()->literal('%'.$find['fullName'].'%')));
            $qb->orWhere( $qb->expr()->like('c.firstName', $qb->expr()->literal('%'.$find['fullName'].'%')));
            $qb->orWhere( $qb->expr()->like('c.patronymic', $qb->expr()->literal('%'.$find['fullName'].'%')));
        }

        $direction = ($sort < 0 )?'desc':'asc';
        $sortcol = array(1=>'c.lastName, c.firstName, c.patronymic', 2=>'ad.name', 3=>'a.originName');
        if ($sort) {
            $qb->addOrderBy($sortcol[abs($sort)], $direction);
        }

        return (new Paginator($qb, $pageSize))->paginate($page);
    }
    // /**
    //  * @return Attachment[] Returns an array of Attachment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Attachment
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
