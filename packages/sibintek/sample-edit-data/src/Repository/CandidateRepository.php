<?php

namespace Sibintek\ConsentPersData\Repository;

use Sibintek\ConsentPersData\Entity\Candidate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sibintek\ConsentPersData\Pagination\Paginator;

/**
 *
 *
 * @method Candidate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidate[]    findAll()
 * @method Candidate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidate::class);
    }

    public function findLatest(int $page = 1, int $pageSize = 10, $sort = null, $find): Paginator
    {
        $qb = $this->createQueryBuilder('c')
            ->addSelect('e')
            ->leftJoin('c.emailAddresses', 'e')
        ;

        if ($find['name']) {
            $qb->andWhere('c.lastName LIKE :searchTerm OR c.firstName LIKE :searchTerm OR c.patronymic LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$find['name'].'%');
        }
        if ($find['fdate']) {
            $qb->andWhere( 'c.birthday >= :fdate');
            $qb->setParameter('fdate', $find['fdate']);
        }
        if ($find['ldate']) {
            $qb->andWhere( 'c.birthday <= :ldate');
            $qb->setParameter('ldate', $find['ldate']);
        }

        $direction = ($sort < 0 )?'desc':'asc';
        $sortcol = array(1=>'lastName', 2=>'firstName', 3=>'patronymic', 4=>'birthday');
        if ($sort) {
            $qb->addOrderBy('c.' . $sortcol[abs($sort)], $direction);
        }

        return (new Paginator($qb, $pageSize))->paginate($page);
    }

    public function findBySearchQuery(string $query, int $limit ): array // = Post::NUM_ITEMS
    {

        $queryBuilder = $this->createQueryBuilder('c');

        $queryBuilder
            ->orWhere('c.lastName LIKE :t_')
            ->setParameter('t_', '%'.$query.'%')
            ->orWhere('c.firstName LIKE :t_')
            ->setParameter('t_', '%'.$query.'%')
            ->orWhere('c.patronymic LIKE :t_')
            ->setParameter('t_', '%'.$query.'%')
        ;

        return $queryBuilder
            ->orderBy('c.lastName', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }



    // /**
    //  * @return Candidate[] Returns an array of Candidate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Candidate
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
