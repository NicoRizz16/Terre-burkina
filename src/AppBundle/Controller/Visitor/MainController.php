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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('visitor/main/index.html.twig');
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
                        'message' => $post['message']
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
}
