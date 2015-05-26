<?php

namespace MairieVoreppe\UsefulBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MairieVoreppeUsefulBundle:Default:index.html.twig', array('name' => $name));
    }
}
