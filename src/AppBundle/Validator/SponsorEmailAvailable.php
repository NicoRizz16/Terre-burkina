<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 04/06/2017
 * Time: 08:09
 */

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SponsorEmailAvailable extends Constraint
{
    public $userMessage = "Cet e-mail correspond déjà à un utilisateur du site.";

    public $requestMessage = "Une demande d'informations/de parrainage est déjà en cours avec cette adresse e-mail.";
}