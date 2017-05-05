<?php
// AppBundle\Security\LoginSuccessHandler.php

namespace AppBundle\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $authorizationChecker;

    public function __construct(Router $router, AuthorizationChecker $authorizationChecker) {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

        $response = null;

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')
            || $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')
            || $this->authorizationChecker->isGranted('ROLE_MODERATOR'))
        {
            $response = new RedirectResponse($this->router->generate('admin_board'));

        } else if ($this->authorizationChecker->isGranted('ROLE_COORDINATOR')) {
            $response = new RedirectResponse($this->router->generate('admin_board'));

        } else if ($this->authorizationChecker->isGranted('ROLE_SPONSOR')) {
            $response = new RedirectResponse($this->router->generate('fasoma_homepage'));

        } else if ($this->authorizationChecker->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('homepage'));
        }

        return $response;
    }

}

