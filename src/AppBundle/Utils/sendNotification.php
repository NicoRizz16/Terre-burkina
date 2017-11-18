<?php

namespace AppBundle\Utils;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class sendNotification
{
    private $mailer;
    private $templating;
    private $mailer_user;
    private $router;

    public function __construct(\Swift_Mailer $mailer, $templating, $mailer_user, Router $router)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->mailer_user = $mailer_user;
        $this->router = $router;
    }

    public function sendNotification(User $user)
    {
        // ABOLITION DES NOTIFICATIONS TEMPORAIRE
        return;

        $secondsSinceLastContact = abs(((new \DateTime())->getTimestamp())-($user->getLastContact()->getTimestamp()));
        if($secondsSinceLastContact <= 1800){
            return; // Pas de mail si dernier contact dans les 30 dernières minutes (eviter spam)
        }

        $message = \Swift_Message::newInstance()
            ->setSubject("Notification espace Fasoma")
            ->setFrom($this->mailer_user)
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'email/send_notification.html.twig', array(
                        'user' => $user,
                        'url' => $this->router->generate('fasoma_homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL)
                    )
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }


}