<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 04/06/2017
 * Time: 08:10
 */

namespace AppBundle\Validator;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SponsorEmailAvailableValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function Validate($value, Constraint $constraint)
    {
        // Vérificaiton si l'email existe déjà dans SponsorshipRequest
        $sponsorshipRequest = $this->em->getRepository('AppBundle:SponsorshipRequest')->findOneBy(array('email' => $value));
        if($sponsorshipRequest){
            $this->context->buildViolation($constraint->requestMessage)
                ->addViolation();
        }

        // Vérificaiton si l'email existe déjà dans User
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(array('email' => $value));
        if($user){
            $this->context->buildViolation($constraint->userMessage)
                ->addViolation();
        }

    }
}