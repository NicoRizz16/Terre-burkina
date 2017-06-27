<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 05/05/2017
 * Time: 20:23
 */

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

class NewsletterRepository extends \Doctrine\ORM\EntityRepository
{
    public function getEmails($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('n')
            ->orderBy('n.email', 'ASC')
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