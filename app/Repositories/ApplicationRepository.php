<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ApplicationRepository extends EntityRepository
{
    public function findForPage($page = 1, $pageSize = 50) : Paginator
    {
        $qb = $this->createQueryBuilder('a');

        $query = $qb
            ->orderBy('a.id', 'DESC')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery();

        return new Paginator($query, $fetchJoinCollection = true);
    }
}
