<?php

namespace MairieVoreppe\SecurityBundle\Component\Authentication\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
	
	protected $router;
	protected $security;
        protected $session;
	
	public function __construct(Router $router, SecurityContext $security, Session $session)
	{
		$this->router = $router;
		$this->security = $security;
                $this->session = $session;                
	}
	
	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
            // redirect the user to where they were before the login process begun.
            // Utile si l'accès à l'application ne nécessite pas forcement une connexion
            // Sans quoi ce sera toujours celle-ci qui sera retenue
            /*referer_url = $request->headers->get('referer');            
            $response = new RedirectResponse($referer_url);*/
            $user = $this->security->getToken()->getUser();
            
            $response = new RedirectResponse($this->router->generate('mairie_voreppe_demande_travaux_homepage'));
            if(count($user->getServices()) > 1)
            {
                $response = new RedirectResponse($this->router->generate('mairie_voreppe_security_parametrage_service_new'));
                $this->session->set('just_login', true);
            }

            return $response;
	}
	
}