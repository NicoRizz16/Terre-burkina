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

    public function getSponsors($page, $nbPerPage, $by, $order)
    {
        $by = $this->byWhiteList($by);
        $order = $this->orderWhiteList($order);

        $query = $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :roles')
            ->setParameter('roles', '%ROLE_SPONSOR%')
            ->orderBy('u.'.$by, $order)
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

    public function getSponsorsQueryBuilder()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.lastName', 'ASC')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_SPONSOR%')
            ;
    }

    private function byWhiteList($by){
        $whitelist = array('firstName', 'lastName', 'adress', 'paymentChoice', 'lastPayment', 'lastContact');
        if(!in_array($by, $whitelist)){
            return 'lastName';
        }
        return $by;
    }

    private function orderWhiteList($order){
        $whitelist = array('ASC', 'DESC');
        if(!in_array($order, $whitelist)){
            return 'ASC';
        }
        return $order;
    }

    public function getModeratorAndAdminQueryBuilder()
    {
        return $this->createQueryBuilder('u')
            ->where('u.roles LIKE :rolemod')
            ->setParameter('rolemod', '%ROLE_MODERATOR%')
            ->orWhere('u.roles LIKE :roleadmin')
            ->setParameter('roleadmin', '%ROLE_ADMIN%')
            ->orderBy('u.username', 'ASC');
    }

    public function getCoordinators(){
        return $this->createQueryBuilder('u')
            ->orderBy('u.username', 'ASC')
            ->where('u.roles LIKE :roleAdmin')
            ->setParameter('roleAdmin', '%ROLE_ADMIN%')
            ->orWhere('u.roles LIKE :roleSuper')
            ->setParameter('roleSuper', '%ROLE_SUPER_ADMIN%')
            ->orWhere('u.roles LIKE :roleModerator')
            ->setParameter('roleModerator', '%ROLE_MODERATOR%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getSponsorsList()
    {
        return $this->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_SPONSOR%')
            ->orderBy('u.lastName', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
