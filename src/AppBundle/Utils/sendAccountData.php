<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 01/05/2017
 * Time: 17:08
 */

namespace AppBundle\Utils;


use AppBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Util\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class sendAccountData
{
    private $mailer;
    private $templating;
    private $mailer_user;
    private $router;
    private $tokenGenerator;
    private $fosUserManager;

    public function __construct(\Swift_Mailer $mailer, $templating, $mailer_user, Router $router, TokenGenerator $tokenGenerator, UserManager $fosUserManager)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->mailer_user = $mailer_user;
        $this->router = $router;
        $this->tokenGenerator = $tokenGenerator;
        $this->fosUserManager = $fosUserManager;
    }

    public function sendAccountData(User $user)
    {
        $this->generateResetToken($user);

        $message = \Swift_Message::newInstance()
            ->setSubject("Connexion à votre compte sur Terre Burkina")
            ->setFrom($this->mailer_user)
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'email/send_account_data.html.twig', array(
                        'user' => $user,
                        'url' => $this->getResettingUrl($user)
                        )
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    private function generateResetToken(User $user)
    {
        $user->setConfirmationToken($this->tokenGenerator->generateToken());
        $user->setPasswordRequestedAt(new \DateTime());
        $this->fosUserManager->updateUser($user);

    }

    private function getResettingUrl(User $user)
    {
        return $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
    }

}