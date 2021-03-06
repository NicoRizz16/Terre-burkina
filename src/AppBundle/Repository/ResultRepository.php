<?php

namespace AppBundle\Repository;

/**
 * ResultRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ResultRepository extends \Doctrine\ORM\EntityRepository
{
    public function getChildResultsByDate($id)
    {
        $query = $this->createQueryBuilder('r')
            ->leftjoin('r.child', 'c', 'WITH')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->orderBy('r.year', 'DESC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
