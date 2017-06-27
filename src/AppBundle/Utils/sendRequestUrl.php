<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 01/05/2017
 * Time: 17:08
 */

namespace AppBundle\Utils;

use AppBundle\Entity\SponsorshipRequest;

class sendRequestUrl
{
    private $mailer;
    private $templating;
    private $mailer_user;

    public function __construct(\Swift_Mailer $mailer, $templating, $mailer_user)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->mailer_user = $mailer_user;
    }

    public function sendRequestUrl(SponsorshipRequest $sponsorshipRequest, $url)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject("Informations sur le parrainage d'enfants du Burkina Faso")
            ->setFrom($this->mailer_user)
            ->setTo($sponsorshipRequest->getEmail())
            ->setBody(
                $this->templating->render(
                    'email/send_request_url.html.twig', array(
                        'firstName' => $sponsorshipRequest->getFirstName(),
                        'lastName' => $sponsorshipRequest->getLastName(),
                        'url' => $url
                    )
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

}