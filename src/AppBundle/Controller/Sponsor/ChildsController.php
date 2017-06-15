<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Sponsor;

use AppBundle\Entity\Child;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/fasoma/filleul")
 * @Security("has_role('ROLE_SPONSOR')")
 */
class ChildsController extends Controller
{
    /**
     * @Route("/{id}/informations", name="fasoma_child_infos", requirements={"id": "\d+"})
     */
    public function infosAction(Child $child)
    {
        $user = $this->getUser();
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }
        if(!$user->hasChild($child)){
            throw $this->createAccessDeniedException('Vous n\'avez pas accès aux informations sur ce filleul.');
        }

        return $this->render('sponsor/child/infos.html.twig', array(
            'child' => $child
        ));
    }

    /**
     * @Route("/{id}/nouvelles", name="fasoma_child_news", requirements={"id": "\d+"})
     */
    public function newsAction(Child $child)
    {
        $user = $this->getUser();
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }
        if(!$user->hasChild($child)){
            throw $this->createAccessDeniedException('Vous n\'avez pas accès aux informations sur ce filleul.');
        }

        return $this->render('sponsor/child/news.html.twig', array(
            'child' => $child
        ));
    }

    /**
     * @Route("/{id}/photos", name="fasoma_child_photos", requirements={"id": "\d+"})
     */
    public function photosAction(Child $child)
    {
        $user = $this->getUser();
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }
        if(!$user->hasChild($child)){
            throw $this->createAccessDeniedException('Vous n\'avez pas accès aux informations sur ce filleul.');
        }

        return $this->render('sponsor/child/photos.html.twig', array(
            'child' => $child
        ));
    }

    /**
     * @Route("/{id}/resultats", name="fasoma_child_results", requirements={"id": "\d+"})
     */
    public function resultsAction(Child $child)
    {
        $user = $this->getUser();
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }
        if(!$user->hasChild($child)){
            throw $this->createAccessDeniedException('Vous n\'avez pas accès aux informations sur ce filleul.');
        }

        return $this->render('sponsor/child/results.html.twig', array(
            'child' => $child
        ));
    }
}
