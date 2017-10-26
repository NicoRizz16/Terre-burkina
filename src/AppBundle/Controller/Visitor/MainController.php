<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Visitor;

use AppBundle\Entity\Donation;
use AppBundle\Entity\Newsletter;
use AppBundle\Form\ContactType;
use AppBundle\Form\DonateType;
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
     * @Route("/nos-actions", name="nos_actions")
     */
    public function nosActionsAction()
    {
        $listActions = $this->getDoctrine()->getManager()->getRepository('AppBundle:Action')->findBy(array(), array('priority' => 'DESC'));
        return $this->render('visitor/main/nos_actions.html.twig', array(
            'listActions' => $listActions
        ));
    }

    /**
     * @Route("/maison-de-luc", name="maison_de_luc")
     */
    public function maisonDeLucAction()
    {
        return $this->render('visitor/main/maison_de_luc.html.twig');
    }

    /**
     * @Route("/mentions-legales", name="mensions_legales")
     */
    public function mensionsLegalesAction()
    {
        return $this->render('visitor/main/mentions_legales.html.twig');
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
                $this->get('app.subscribe_newsletter')->subscribeNewsletter($post['email']);
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
            $this->get('app.subscribe_newsletter')->subscribeNewsletter($newsletter->getEmail());
            $title = "Inscription à la newsletter réussie";
            $body = "Vous êtes maintenant inscrit à la newsletter !";
        } else { // Si le formulaire n'est pas valide
            $title = "Echec de l'inscription à la newsletter";
            $body = "L'adresse email indiquée n'est pas valide ou fait déjà l'objet d'une inscription à la newsletter.";
        }
        return new JsonResponse(array('title' => $title, 'body' =>$body), 200);
    }

    /**
     * @Route("/don", name="donate")
     */
    public function donateAction(){

        $form = $this->createForm(DonateType::class);

        return $this->render('visitor/main/donate.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/ajax/donation", name="ajax_donate")
     * @Method("POST")
     */
    public function ajaxDonateAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $form = $this->createForm(DonateType::class);
        $form->handleRequest($request);
        if ($form->isValid()){
            if($request->request->get('submittedBtn') == "donate_card"){ // Paiement par carte
                // Enregistrement du montant du don dans une variable session
                $session = $request->getSession();
                $session->set('donationAmount', $form->get('amount')->getData());

                return new JsonResponse(array(
                    'payment' => 'card',
                    'paymentView' => $this->renderView('visitor/main/_stripe_button.html.twig', array(
                        'publicKey' => $this->getParameter('stripe_public_key'),
                        'donationAmount' => $form->get('amount')->getData()
                    ))), 200);

            } elseif($request->request->get('submittedBtn') == "donate_cheque"){ // Paiement par chèque
                return new JsonResponse(array('payment' => 'cheque'), 200);

            } elseif($request->request->get('submittedBtn') == "donate_transfer"){ // Paiement par virement bancaire
                return new JsonResponse(array('payment' => 'transfer'), 200);
            }
        }

        return new JsonResponse(
            array(
                'message' => 'Error!',
                'form' => $this->renderView('visitor/main/_donate_form.html.twig',
                    array(
                        'form' => $form->createView()
                    ))
            ), 400);
    }

    /**
     * @Route("/don/paiement", name="charge_donation")
     */
    public function chargeDonation(Request $request){
        // clé secrète Stripe
        \Stripe\Stripe::setApiKey($this->getParameter('stripe_private_key'));

        $session = $request->getSession();
        $amount = $session->get('donationAmount');

        // Récupération du token généré par le formulaire checkout
        $token = $request->get('stripeToken');

        if(!$amount | !isset($token)){
            $this->addFlash('error', 'Nous avons rencontré un problème lors de la procédure du paiement, veuillez réessayer.');
            return $this->redirectToRoute('donate');
        }

        try { // On procède au paiement
            \Stripe\Charge::create(array(
                "amount" => $amount*100,
                "currency" => "eur",
                "description" => "Example charge",
                "source" => $token,
            ));
        } catch(\Stripe\Error\Card $e) { // Gestion des erreurs concernant les informations de paiement
            $body = $e->getJsonBody();
            $err = $body['error'];
            $this->addFlash('error', $err['message']);
            return $this->redirectToRoute('donate');
        } catch (\Stripe\Error\Base $e) { // Gestion globale des erreurs
            $this->addFlash('error', 'Nous avons rencontré un problème lors de la procédure du paiement, veuillez réessayer.');
            return $this->redirectToRoute('donate');
        }

        // On enregistre la donation
        $donation = new Donation();
        $donation->setAmount($amount);
        $em = $this->getDoctrine()->getManager();
        $em->persist($donation);
        $em->flush();

        // On réinitialise la session
        $session->set('donationAmount', null);

        return $this->render('visitor/main/confirm.html.twig');
    }

}
