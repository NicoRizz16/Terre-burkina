<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 01/05/2017
 * Time: 17:08
 */

namespace AppBundle\Utils;

class sendAccountData
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

    public function sendAccountData($mailTo, $username, $password)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject("Données de connexion à votre compte")
            ->setFrom($this->mailer_user)
            ->setTo($mailTo)
            ->setBody(
                $this->templating->render(
                    'email/send_account_data.html.twig', array(
                        'username' => $username,
                        'password' => $password
                        )
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

}