<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 25/06/2017
 * Time: 05:59
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Record;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class addRecord
{
    private $em;
    private $tokenStorage;

    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public function addRecord($content)
    {
        $Record = new Record();

        $Record->setUser($this->tokenStorage->getToken()->getUser());
        $Record->setContent($content);

        $this->em->persist($Record);
        $this->em->flush();
    }

}