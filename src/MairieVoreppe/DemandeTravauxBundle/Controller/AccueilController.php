<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{
    public function indexAction()
    {
        
        return $this->render('MairieVoreppeDemandeTravauxBundle:Accueil:index.html.twig');
    }
}
