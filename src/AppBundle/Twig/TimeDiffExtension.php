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

        } elseif($interval->format('%m') != 0){
            return $interval->format('%m mois');

        } else {
            switch ($interval->format('%a')){
                case 0 :
                    return "Aujourd'hui";
                    break;
                case 1 :
                    return "Hier";
                    break;
                case 2 :
                    return "Avant-hier";
                    break;
                default:
                    return $interval->format('%a')." jours";
                    break;
            }
        }
    }

    public function dayDiff(\DateTime $date)
    {
        $now = new \DateTime();
        $interval = $date->diff($now);
        return $interval->format('%a');
    }

}