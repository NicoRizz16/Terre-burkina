<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ChildRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChildRepository extends \Doctrine\ORM\EntityRepository
{
    public function getChilds($page, $nbPerPage, $by, $order)
    {
        $by = $this->byWhiteList($by);
        $order = $this->orderWhiteList($order);

        $query = $this->createQueryBuilder('c')
            ->orderBy('c.'.$by, $order)
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

    private function byWhiteList($by){
        $whitelist = array('firstName', 'lastName', 'adress', 'dateOfBirth', 'school', 'class', 'familySituation');
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

    public function getOrphanChildsQueryBuilder()
    {
        return $this->createQueryBuilder('c')
            ->where('c.sponsor IS NULL')
            ->orderBy('c.fullName', 'ASC');
    }

    public function getChildsListQueryBuilder()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.fullName', 'ASC')
            ;
    }

    public function getFollowUpChilds($page, $nbPerPage, $by, $isByAChildParameter, $order, User $coordinator = null)
    {
        $by = $this->byFollowUpWhiteList($by);
        $order = $this->orderWhiteList($order);

        $query = $this->createQueryBuilder('c')
            ->leftjoin('c.sponsor', 's', 'WITH');

        if($coordinator != null){
            $query->where('c.coordinator = '.$coordinator->getId());
        }

        if($isByAChildParameter){
            $query->orderBy('c.'.$by, $order);
        } else {
            $query->orderBy('s.'.$by, $order);
        }

        $query->getQuery();

        $query
            // On définit l'annonce à partir de laquelle commencer la liste
            ->setFirstResult(($page-1)*$nbPerPage)
            // Ainsi que le nombre d'annonce à afficher sur une page
            ->setMaxResults($nbPerPage)
        ;

        // On retourne l'objet Paginator correspondant à la requête construite
        return new Paginator($query, true);
    }

    private function byFollowUpWhiteList($order){
        $whitelist = array('lastName', 'dateOfBirth', 'followUpAdress', 'school', 'class', 'familySituation', 'sponsorshipType', 'sponsorshipStatus', 'adress', 'phone', 'email', 'paymentChoice');
        if(!in_array($order, $whitelist)){
            return 'lastName';
        }
        return $order;
    }
}
