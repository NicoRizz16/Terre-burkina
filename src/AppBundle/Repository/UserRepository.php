<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * UserRepository
 *
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

    public function getUsers($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('user')
            ->orderBy('user.username', 'ASC')
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
