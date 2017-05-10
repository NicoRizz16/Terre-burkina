<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ChildRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChildRepository extends \Doctrine\ORM\EntityRepository
{
    public function getChilds($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.lastName', 'ASC')
            ->getQuery()
        ;

        $query
            // On définit l'annonce à partir de laquelle commencer la liste
            ->setFirstResult(($page-1)*$nbPerPage)
            // Ainsi que le nombre d'annonce à afficher sur une page
            ->setMaxResults($nbPerPage)
        ;

        // On retourne l'objet Paginator correspondant à la requête construite
        return new Paginator($query, true);
    }
}
