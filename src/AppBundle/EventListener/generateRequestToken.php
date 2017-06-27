<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 04/06/2017
 * Time: 09:38
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\SponsorshipRequest;
use Doctrine\ORM\Event\LifecycleEventArgs;
use FOS\UserBundle\Util\TokenGenerator;

class generateRequestToken
{
    private $tokenGenerator;

    public function __construct(TokenGenerator $tokenGenerator)
    {
        $this->tokenGenerator = $tokenGenerator;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // On agit seulement si c'est une entité SponsorshipRequest
        if (!$entity instanceof SponsorshipRequest){
            return;
        }

        $entity->setToken($this->tokenGenerator->generateToken());
    }
}