<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 11:30
 */

namespace AppBundle\Controller\Visitor;

use AppBundle\AppBundle;
use AppBundle\Entity\Gallery;
use AppBundle\Entity\Newsletter;
use AppBundle\Entity\SponsorshipRequest;
use AppBundle\Form\RequestInfoType;
use AppBundle\Form\RequestSponsorshipType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @Route("/systeme-scolaire", name="sponsorship_school_system")
     */
    public function schoolSystemAction(Request $request)
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

        return $this->render('visitor/sponsorships/school_system.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/galerie/{page}", name="sponsorship_gallery", requirements={"id": "\d+"})
     */
    public function galleryAction(Request $request, $page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

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

        $nbPerPage = Gallery::NUM_ITEMS;
        $photos = $em->getRepository('AppBundle:Gallery')->getPhotosPaginateByOrder($page, $nbPerPage);
        $nbPageTotal = ceil(count($photos)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('visitor/sponsorships/gallery.html.twig', array(
            'form' => $form->createView(),
            'photos' => $photos,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
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

            $isUserWithSameMail = $em->getRepository('AppBundle:User')->findOneBy(array('email' => $sponsorshipRequest->getEmail()));
            if(!$isUserWithSameMail){
                $isRequestWithSameMail = $em->getRepository('AppBundle:SponsorshipRequest')->findOneBy(array('email' => $sponsorshipRequest->getEmail()));
                if(!$isRequestWithSameMail || ($isRequestWithSameMail->getIsSponsorshipRequest() == false)){
                    if($isRequestWithSameMail){
                        $em->remove($isRequestWithSameMail);
                        $em->flush();
                    }
                    $this->manageNewsletterSubscription($sponsorshipRequest);
                    $sponsorshipRequest->setIsSponsorshipRequest(true);
                    $em->persist($sponsorshipRequest);
                    $em->flush();
                    $this->addFlash('info', 'Votre demande de parrainage a bien été prise en compte, nous vous recontacterons au plus vite.');
                    return $this->redirectToRoute('sponsorship_request');

                } else {
                    $this->addFlash('error', 'Une demande de parrainage est déjà en cours avec cette adresse e-mail.');
                }

            } else {
                $this->addFlash('error', 'Cet adresse e-mail est déjà attribuée à un utilisateur du site.');
            }
        }

        return $this->render('visitor/sponsorships/become_sponsor.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function manageNewsletterSubscription(SponsorshipRequest $sponsorshipRequest)
    {
        if($sponsorshipRequest->getNewsletter()){ // Inscription à la newsletter si case cochée
            $this->get('app.subscribe_newsletter')->subscribeNewsletter($sponsorshipRequest->getEmail());
        }
    }

    /**
     * @Route("/{token}", name="sponsorship_request_response")
     */
    public function accessRequestResponseAction(SponsorshipRequest $sponsorshipRequest)
    {
        if(!$sponsorshipRequest->getIsValid() || ($sponsorshipRequest->getExpirationDate()->format('Ymd') <= ((new \DateTime())->format('Ymd')))){
            throw $this->createNotFoundException();
        }

        return $this->render('visitor/sponsorships/request_response.html.twig', array(
            'sponsorshipRequest' => $sponsorshipRequest
        ));
    }

}