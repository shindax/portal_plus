<?php

namespace Sibintek\ConsentPersData\Repository;

use Sibintek\ConsentPersData\Entity\EmailAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sibintek\ConsentPersData\Pagination\Paginator;

/**
 * @method EmailAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailAddress[]    findAll()
 * @method EmailAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailAddress::class);
    }

    public function findLatest(int $page = 1, int $pageSize = 10, int $sort = null, $find): Paginator
    {
        $qb = $this->createQueryBuilder('e')
            ->addSelect('c')
            ->leftJoin('e.candidate', 'c')
        ;

        if ($find['name']) {
            $qb->andWhere( $qb->expr()->like('e.name', $qb->expr()->literal('%'.$find['name'].'%')));
        }
        if ($find['fdate']) {
            $qb->andWhere( 'e.datesent >= :fdate');
            $qb->setParameter('fdate', $find['fdate']);
        }
        if ($find['ldate']) {
            $qb->andWhere( 'e.datesent <= :ldate');
            $qb->setParameter('ldate', $find['ldate']);
        }

        $direction = ($sort < 0 )?'desc':'asc';
        $sortcol = array(1=>'name', 2=>'datesent');
        if ($sort) {
            $qb->addOrderBy('e.' . $sortcol[abs($sort)], $direction);
        }

        return (new Paginator($qb, $pageSize))->paginate($page);
    }


    public function findBySearchQuery(string $query, int $limit): array
    {
        $searchTerms = $this->extractSearchTerms($query);

        if (0 === \count($searchTerms)) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('p');

        foreach ($searchTerms as $key => $term) {
            $queryBuilder
                ->orWhere('p.title LIKE :t_'.$key)
                ->setParameter('t_'.$key, '%'.$term.'%')
            ;
        }

        return $queryBuilder
            ->orderBy('p.publishedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return EmailAddress[] Returns an array of EmailAddress objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmailAddress
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
