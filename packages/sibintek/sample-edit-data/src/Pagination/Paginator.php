<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sibintek\ConsentPersData\Pagination;

use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;
use Doctrine\ORM\Tools\Pagination\CountWalker;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

/**
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class Paginator
{
    private const PAGE_SIZE = 10;
    private $queryBuilder;
    private $currentPage;
    private $pageSize;
    private $results;
    private $numResults;
    private $arrPage;

    public function __construct(DoctrineQueryBuilder $queryBuilder, int $pageSize = self::PAGE_SIZE)
    {
        $this->queryBuilder = $queryBuilder;
        $this->pageSize = $pageSize;
    }

    public function paginate(int $page = 1): self
    {
        $this->currentPage = max(1, $page);
        $firstResult = ($this->currentPage - 1) * $this->pageSize;

        $query = $this->queryBuilder
            ->setFirstResult($firstResult)
            ->setMaxResults($this->pageSize)
            ->getQuery();

        if (0 === \count($this->queryBuilder->getDQLPart('join'))) {
            $query->setHint(CountWalker::HINT_DISTINCT, false);
        }

        $paginator = new DoctrinePaginator($query, true);

        $useOutputWalkers = \count($this->queryBuilder->getDQLPart('having') ?: []) > 0;
        $paginator->setUseOutputWalkers($useOutputWalkers);

        $this->results = $paginator->getIterator();
        $this->numResults = $paginator->count();
//        var_dump($this);die;
        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return (int) ceil($this->numResults / $this->pageSize);
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    public function getPreviousPage(): int
    {
        return max(1, $this->currentPage - 1);
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->getLastPage();
    }

    public function getNextPage(): int
    {
        return min($this->getLastPage(), $this->currentPage + 1);
    }

    public function hasToPaginate(): bool
    {
        return $this->numResults > $this->pageSize;
    }

    public function getNumResults(): int
    {
        return $this->numResults;
    }

    public function getResults(): \Traversable
    {
        return $this->results;
    }

    public function getArrayPage()
    {
        $this->arrPage[] = 1;

        $start = $this->currentPage - 3;
        if ($start <= 1) {
            $start = 1;
        }
        $sp = $this->currentPage - 4;
        if ($sp < $start && $sp > 1) {
            $sp = $start - 1;
            $this->arrPage[] =  $sp;
        }

        $end = $this->currentPage + 3;
        if ($end > $this->getLastPage()) {
            $end = $this->getLastPage();
            $is_next = false;
        }
        for ($i = $start; $i <= $end; $i++) {
            if ($i != $this->getLastPage() &&  $i != 1) $this->arrPage[] = $i;
        }

        if ($end + 1 < $this->getLastPage()) {
            $sp = $end + 1;
            $this->arrPage[] = $sp;
        }
        $this->arrPage[] = $this->getLastPage();

        return $this->arrPage;
    }
}
