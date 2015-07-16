<?php

namespace Application\Sonata\UserBundle\Controller;

//On hérite de tout SecurityController de FOUserBundle ainsi que de toute les URL de sonata
use Sonata\UserBundle\Controller\SecurityFOSUser1Controller as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContext;
/**
 * {@inheritDoc}
 */
class SecurityFOSUser1Controller extends BaseController
{
    /**
    * {@inheritDoc}
    */
    public function loginAction()
    {
        $request = $this->container->get('request');
        $doctrine = $this->container->get('doctrine');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        
        //Ne sachant pas dans quel service l'utilisateur se situe je propose l'ensemble des services
        

        $services = $doctrine->getEntityManager()->getRepository('MairieVoreppeUserBundle:Service')->findAll();
        
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
            'services' => $services
        ));
    }
    
    /**
     * {@inheritDoc}
     */
    public function renderLogin(array $data)
    {
        $requestAttributes = $this->container->get('request')->attributes;
                
        
        if ('admin_login' === $requestAttributes->get('_route')) 
        {
            $template = sprintf('MairieVoreppeUserBundle:Security:admin_login.html.twig');
        } 
        else 
        {
            $template = sprintf('MairieVoreppeUserBundle:Security:login.html.twig');
        }

        return $this->container->get('templating')->renderResponse($template, $data);
    }
}