<?php

namespace MairieVoreppe\SecurityBundle\Component\Authentication\Handler;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
	
    protected $router;

    public function __construct(Router $router)
    {
            $this->router = $router;
    }

    public function onLogoutSuccess(Request $request)
    {
            // redirect the user to where they were before the login process begun. Utile si l'accès à l'application ne nécessite pas forcement une
            //connexion
            $referer_url = $request->headers->get('referer');

            $response = new RedirectResponse($referer_url);		
            return $response;
    }
	
}