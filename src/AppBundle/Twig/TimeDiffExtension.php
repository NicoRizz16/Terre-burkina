<?php

namespace AppBundle\Twig;

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 30/05/2017
 * Time: 15:45
 */
class TimeDiffExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('timeDiff', array($this, 'timeDiff')),
            new \Twig_SimpleFunction('dayDiff', array($this, 'dayDiff'))
        );
    }

    public function timeDiff(\DateTime $date)
    {
        $now = new \DateTime();
        $interval = $date->diff($now);

        if($interval->format('%Y') != 0){
            $an = ($interval->format('%y') > 1) ? "ans" : "an";
            return $interval->format('%y')." ".$an;
        }
        if($interval->format('%m') != 0){
            return $interval->format('%m mois');
        } else {
            $jour = ($interval->format('%a') > 1) ? "jours" : "jour";
            return $interval->format('%a')." ".$jour;
        }
    }

    public function dayDiff(\DateTime $date)
    {
        $now = new \DateTime();
        $interval = $date->diff($now);
        return $interval->format('%a');
    }

}