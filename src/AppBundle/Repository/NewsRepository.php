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
class NewsRepository extends \Doctrine\ORM\EntityRepository
{
    public function getValidChildNewsPaginateByDate($childID, $page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('n')
            ->leftjoin('n.child', 'c', 'WITH')
            ->where('c.id = :childID')
            ->setParameter('childID', $childID)
            ->andWhere('n.isValid = true')
            ->orderBy('n.creationDate', 'DESC')
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

    public function getValidGroupNewsPaginateByDate($groupID, $page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('n')
            ->leftjoin('n.group', 'g', 'WITH')
            ->where('g.id = :groupID')
            ->setParameter('groupID', $groupID)
            ->andWhere('n.isValid = true')
            ->orderBy('n.creationDate', 'DESC')
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

    public function getValidNewsPaginateByDate(Child $child, $page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('n');

        $query->orWhere('n.child = '.$child->getId());

        foreach ($child->getGroups() as $group){
            $query->orWhere('n.group = '.$group->getId());
        }

        $query
            ->andWhere('n.isValid = true')
            ->orderBy('n.creationDate', 'DESC')
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

    public function getUserChildsLastNews(User $user)
    {
        $query = $this->createQueryBuilder('n');

        foreach ($user->getChilds() as $child){
            $query->orWhere('n.child = '.$child->getId());

            foreach ($child->getGroups() as $group){
                $query->orWhere('n.group = '.$group->getId());
            }
        }

        $query
            ->setFirstResult(0)
            ->setMaxResults(3)
            ->orderBy('n.creationDate', 'DESC')
        ;

        return $query->getQuery()->getResult();
    }
}
