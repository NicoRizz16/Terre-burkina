<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Visitor;

use AppBundle\Entity\Newsletter;
use AppBundle\Form\ContactType;
use AppBundle\Form\NewsletterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // Récupération des 3 derniers articles
        $lastPosts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->findBy(array('published' => true), array('creationDate' => 'DESC'), 3, 0);

        return $this->render('visitor/main/index.html.twig', array(
            'lastPosts' => $lastPosts
        ));
    }

    /**
     * @Route("/association", name="association")
     */
    public function associationAction()
    {
        return $this->render('visitor/main/association.html.twig');
    }

    /**
     * @Route("/maison-de-luc", name="maison_de_luc")
     */
    public function maisonDeLucAction()
    {
        return $this->render('visitor/main/maison_de_luc.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $message = \Swift_Message::newInstance()
                ->setSubject($post['object'])
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo($this->getParameter('send_contact_mail_to'))
                ->setBody(
                    $this->renderView('email/contact.html.twig', array(
                        'civility' => $post['civility'],
                        'name' => $post['name'],
                        'email' => $post['email'],
                        'phone' => $post['phone'],
                        'knowUs' => $post['knowUs'],
                        'object' => $post['object'],
                        'message' => nl2br($post['message'])
                        )
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);

            // Enregistrement à la newsletter si case cochée
            if($post['newsletter']){
                $em = $this->getDoctrine()->getManager();
                if(!$em->getRepository('AppBundle:Newsletter')->findOneBy(array('email' => $post['email']))){
                    $newsletter = new Newsletter();
                    $newsletter->setEmail($post['email']);
                    $em->persist($newsletter);
                    $em->flush();
                }
            }

            $this->addFlash('info', 'Votre message a bien été envoyé. Nous vous recontactons au plus vite.');
            return $this->redirectToRoute('contact');
        }

        return $this->render('visitor/main/contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/newsletter", name="newsletter")
     */
    public function newsletterAction()
    {
        // Création du formulaire de la newsletter
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter, array(
            'action' => $this->generateUrl('ajax_newsletter')
        ));
        return $this->render('visitor/main/_newsletter_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/ajax/newsletter", name="ajax_newsletter")
     * @Method("POST")
     */
    public function ajaxNewsletterAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isValid()){
            $newsletterRepository = $em->getRepository('AppBundle:Newsletter');
            $isNewsletter = $newsletterRepository->findOneBy(array('email' => $newsletter->getEmail()));
            if(!$isNewsletter){ // Enregistrement de l'email indiqué si il n'est pas déjà enregistré
                $em->persist($newsletter);
                $em->flush();
            }
            $title = "Inscription à la newsletter réussie";
            $body = "Vous êtes maintenant inscrit à la newsletter !";
        } else { // Si le formulaire n'est pas valide
            $title = "Echec de l'inscription à la newsletter";
            $body = "L'adresse email indiquée n'est pas valide ou fait déjà l'objet d'une inscription à la newsletter.";
        }
        return new JsonResponse(array('title' => $title, 'body' =>$body), 200);
    }
}
