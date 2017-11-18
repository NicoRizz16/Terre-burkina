<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Sponsor;

use AppBundle\Entity\Message;
use AppBundle\Form\EditProfileType;
use AppBundle\Form\MessageType;
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

    /**
     * @Route("/messages", name="fasoma_messages")
     */
    public function messagesAction(Request $request)
    {
        $user = $this->getUser();
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }

        $em = $this->getDoctrine()->getManager();
        // Récupération des messages de l'utilisateur
        $messagesList = $em->getRepository('AppBundle:Message')->getUserMessages($user);

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setUser($user);
            $message->setIsSenderAdmin(false);
            $message->setIsNotificationAdmin(true);
            $em->persist($message);
            $em->flush();

            $this->addFlash('info', 'Le message a bien été envoyé.');
            return $this->redirectToRoute('fasoma_messages');
        } elseif($form->isSubmitted() && !$form->isValid()){
            $this->addFlash('error', 'Le message n\'a pas été enregistré car le formulaire contient une ou plusieurs erreurs.');
        }

        $user->setMessageConsulted(true); // On enlève la notification de messages
        $em->flush();

        return $this->render('sponsor/main/messages.html.twig', array(
            'user' => $user,
            'messages' => $messagesList,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/profil", name="fasoma_profile")
     */
    public function profileAction()
    {
        $user = $this->getUser();
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }

        return $this->render('sponsor/main/profile.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @Route("/profil/modifier", name="fasoma_profile_edit")
     */
    public function profileEditAction(Request $request)
    {
        $user = $this->getUser();
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }

        $error = false;
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $userManager = $this->get('fos_user.user_manager');
            $user->setProfileChanged(true);
            $userManager->updateUser($user);

            // Envoyer une notification de chgt sur la boite mail TB

            $this->addFlash('info', 'Vos informations de compte ont bien été modifiées');
            return $this->redirectToRoute('fasoma_profile');
        } else if($form->isSubmitted()){
            $error = true;
        }

        return $this->render('sponsor/main/profile_edit.html.twig', array(
            'form' => $form->createView(),
            'error' => $error
        ));
    }
}
