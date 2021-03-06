<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Child;
use AppBundle\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PhotoRepository extends \Doctrine\ORM\EntityRepository
{

    public function getPhotosPaginateByOrder(Child $child, $page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('p');

        $query->orWhere('p.child = '.$child->getId());

        foreach ($child->getGroups() as $group){
            $query->orWhere('p.group = '.$group->getId());
        }

        $query
            ->orderBy('p.order', 'DESC')
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
