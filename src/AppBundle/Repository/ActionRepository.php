<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ActionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActionRepository extends \Doctrine\ORM\EntityRepository
{
    public function getActions($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.priority', 'DESC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($page-1)*$nbPerPage)
            ->setMaxResults($nbPerPage)
        ;

        return new Paginator($query, true);
    }
}
