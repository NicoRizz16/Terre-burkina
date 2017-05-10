<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10/05/2017
 * Time: 21:00
 */

namespace AppBundle\Repository;


use Doctrine\ORM\Tools\Pagination\Paginator;

class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPosts($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('post')
            ->orderBy('post.creationDate', 'DESC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($page-1)*$nbPerPage)
            ->setMaxResults($nbPerPage)
        ;

        return new Paginator($query, true);
    }
}