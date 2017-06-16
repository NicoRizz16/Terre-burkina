<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Sponsor;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/fasoma")
 * @Security("has_role('ROLE_SPONSOR')")
 */
class MainController extends Controller
{
    /**
     * @Route("", name="fasoma_homepage")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }

        // Récupération des 3 dernières nouvelles
        $lastNews = $this->getDoctrine()->getRepository('AppBundle:News')->getUserChildsLastNews($user);

        return $this->render('sponsor/main/index.html.twig', array(
            'childs' => $user->getChilds(),
            'user' => $user,
            'lastNews' => $lastNews
        ));
    }

    /**
     * @Route("/documents", name="fasoma_documents")
     */
    public function documentsAction()
    {
        $user = $this->getUser();
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }

        $em = $this->getDoctrine()->getManager();
        // Récupération des documents de l'utilisateur
        $documentsList = $em->getRepository('AppBundle:Document')->getUserDocuments($user);

        $user->setDocumentConsulted(true); // On enlève la notification de documents
        $em->flush();

        return $this->render('sponsor/main/documents.html.twig', array(
            'user' => $user,
            'documentsList' => $documentsList
        ));
    }
}
