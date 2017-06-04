<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 11:30
 */

namespace AppBundle\Controller\Visitor;

use AppBundle\AppBundle;
use AppBundle\Entity\Newsletter;
use AppBundle\Entity\SponsorshipRequest;
use AppBundle\Form\RequestInfoType;
use AppBundle\Form\RequestSponsorshipType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/parrainages")
 */
class SponsorshipsController extends Controller
{
    /**
     * @Route("/", name="sponsorship_presentation")
     */
    public function presentationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sponsorshipRequest = new SponsorshipRequest();
        $form = $this->createForm(RequestInfoType::class, $sponsorshipRequest);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->manageNewsletterSubscription($sponsorshipRequest);
            $sponsorshipRequest->setIsSponsorshipRequest(false);
            $em->persist($sponsorshipRequest);
            $em->flush();
            $this->addFlash('info', 'Votre demande d\'informations a bien été prise en compte, nous vous recontacterons au plus vite.');
            return $this->redirectToRoute('sponsorship_presentation');
        }

        return $this->render('visitor/sponsorships/presentation.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/devenir-parrain", name="sponsorship_request")
     */
    public function becomeSponsorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sponsorshipRequest = new SponsorshipRequest();
        $form = $this->createForm(RequestSponsorshipType::class, $sponsorshipRequest);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->manageNewsletterSubscription($sponsorshipRequest);
            $sponsorshipRequest->setIsSponsorshipRequest(true);
            $em->persist($sponsorshipRequest);
            $em->flush();
            $this->addFlash('info', 'Votre demande de parrainage a bien été prise en compte, nous vous recontacterons au plus vite.');
            return $this->redirectToRoute('sponsorship_request');
        }

        return $this->render('visitor/sponsorships/become_sponsor.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function manageNewsletterSubscription(SponsorshipRequest $sponsorshipRequest)
    {
        $em = $this->getDoctrine()->getManager();

        if($sponsorshipRequest->getNewsletter()){ // Inscription à la newsletter si case cochée
            $alreadyExists = $em->getRepository('AppBundle:Newsletter')->findOneBy(array('email' => $sponsorshipRequest->getEmail()));
            if(!$alreadyExists){
                $newsletter = new Newsletter();
                $newsletter->setEmail($sponsorshipRequest->getEmail());
                $em->persist($newsletter);
                $em->flush();
            }
        }
    }

}