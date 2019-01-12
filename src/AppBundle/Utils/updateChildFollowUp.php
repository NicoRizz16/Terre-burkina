<?php
/**
 * Created by PhpStorm.
 * User: nicolasrizzon
 * Date: 05/01/2019
 * Time: 22:32
 */

namespace AppBundle\Utils;

use AppBundle\Entity\Child;
use AppBundle\Entity\FollowUp;
use Doctrine\ORM\EntityManager;

class updateChildFollowUp
{
    const TYPE_LETTER = 0;
    const TYPE_PHOTO = 1;
    const TYPE_NEWS = 2;
    const TYPE_RESULT = 3;

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function updateChildFollowUp(Child $child, $type)
    {

        if($child->getFollowUp() == null) // Si aucun suivi existant
        {
            $followUp = new FollowUp();
            $child->setFollowUp($followUp);
            $followUp->setChild($child);
        }

        if( (new \DateTime()) > ($child->getFollowUp()->getEndYearDate()) ){
            // SI la date de suivi est dépassée -> réinitialisation du followup
            $child->getFollowUp()->resetFollowUp();
        }

        // Encoder l'évenement de suivi (le bon type pour le mois actuel)
        $month = (int) (new \DateTime())->format('m');
        if($type == updateChildFollowUp::TYPE_LETTER) {
            if((($child->getLastLetterDate()) < ($child->getFollowUp()->getEndYearDate())) && (($child->getLastLetterDate()) >= ($child->getFollowUp()->getBeginYearDate())))
            {
                $month = (int) $child->getLastLetterDate()->format('m');
                switch ($month){
                    case 1:
                        $child->getFollowUp()->setLetter1(true);
                        break;
                    case 2:
                        $child->getFollowUp()->setLetter2(true);
                        break;
                    case 3:
                        $child->getFollowUp()->setLetter3(true);
                        break;
                    case 4:
                        $child->getFollowUp()->setLetter4(true);
                        break;
                    case 5:
                        $child->getFollowUp()->setLetter5(true);
                        break;
                    case 6:
                        $child->getFollowUp()->setLetter6(true);
                        break;
                    case 7:
                        $child->getFollowUp()->setLetter7(true);
                        break;
                    case 8:
                        $child->getFollowUp()->setLetter8(true);
                        break;
                    case 9:
                        $child->getFollowUp()->setLetter9(true);
                        break;
                    case 10:
                        $child->getFollowUp()->setLetter10(true);
                        break;
                    case 11:
                        $child->getFollowUp()->setLetter11(true);
                        break;
                    case 12:
                        $child->getFollowUp()->setLetter12(true);
                        break;
                }
            }
        } elseif($type == updateChildFollowUp::TYPE_NEWS){
            switch ($month) {
                case 1:
                    $child->getFollowUp()->setNews1(true);
                    break;
                case 2:
                    $child->getFollowUp()->setNews2(true);
                    break;
                case 3:
                    $child->getFollowUp()->setNews3(true);
                    break;
                case 4:
                    $child->getFollowUp()->setNews4(true);
                    break;
                case 5:
                    $child->getFollowUp()->setNews5(true);
                    break;
                case 6:
                    $child->getFollowUp()->setNews6(true);
                    break;
                case 7:
                    $child->getFollowUp()->setNews7(true);
                    break;
                case 8:
                    $child->getFollowUp()->setNews8(true);
                    break;
                case 9:
                    $child->getFollowUp()->setNews9(true);
                    break;
                case 10:
                    $child->getFollowUp()->setNews10(true);
                    break;
                case 11:
                    $child->getFollowUp()->setNews11(true);
                    break;
                case 12:
                    $child->getFollowUp()->setNews12(true);
                    break;
            }
        } elseif ($type == updateChildFollowUp::TYPE_PHOTO){
            switch ($month) {
                case 1:
                    $child->getFollowUp()->setPhoto1(true);
                    break;
                case 2:
                    $child->getFollowUp()->setPhoto2(true);
                    break;
                case 3:
                    $child->getFollowUp()->setPhoto3(true);
                    break;
                case 4:
                    $child->getFollowUp()->setPhoto4(true);
                    break;
                case 5:
                    $child->getFollowUp()->setPhoto5(true);
                    break;
                case 6:
                    $child->getFollowUp()->setPhoto6(true);
                    break;
                case 7:
                    $child->getFollowUp()->setPhoto7(true);
                    break;
                case 8:
                    $child->getFollowUp()->setPhoto8(true);
                    break;
                case 9:
                    $child->getFollowUp()->setPhoto9(true);
                    break;
                case 10:
                    $child->getFollowUp()->setPhoto10(true);
                    break;
                case 11:
                    $child->getFollowUp()->setPhoto11(true);
                    break;
                case 12:
                    $child->getFollowUp()->setPhoto12(true);
                    break;
            }
        } elseif ($type == updateChildFollowUp::TYPE_RESULT){
            switch ($month) {
                case 1:
                    $child->getFollowUp()->setResult1(true);
                    break;
                case 2:
                    $child->getFollowUp()->setResult2(true);
                    break;
                case 3:
                    $child->getFollowUp()->setResult3(true);
                    break;
                case 4:
                    $child->getFollowUp()->setResult4(true);
                    break;
                case 5:
                    $child->getFollowUp()->setResult5(true);
                    break;
                case 6:
                    $child->getFollowUp()->setResult6(true);
                    break;
                case 7:
                    $child->getFollowUp()->setResult7(true);
                    break;
                case 8:
                    $child->getFollowUp()->setResult8(true);
                    break;
                case 9:
                    $child->getFollowUp()->setResult9(true);
                    break;
                case 10:
                    $child->getFollowUp()->setResult10(true);
                    break;
                case 11:
                    $child->getFollowUp()->setResult11(true);
                    break;
                case 12:
                    $child->getFollowUp()->setResult12(true);
                    break;
            }
        }

        $this->em->persist($child);
        $this->em->flush();

        return;
        
    }


}