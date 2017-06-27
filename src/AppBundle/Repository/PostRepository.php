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

    public function getPublishedPosts($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('post')
            ->orderBy('post.creationDate', 'DESC')
            ->andWhere('post.published = 1')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($page-1)*$nbPerPage)
            ->setMaxResults($nbPerPage)
        ;

        return new Paginator($query, true);
    }

    public function getPublishedPostsLike($search)
    {
        return $this->createQueryBuilder('post')
            ->andWhere('post.published = 1')
            ->andWhere('post.title LIKE :search')
            ->setParameter('search',  '%'.$search.'%')
            ->orderBy('post.creationDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}