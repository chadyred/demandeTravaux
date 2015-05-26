<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TravauxController extends Controller
{
     public function indexAction()
    {        
         $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('\MairieVoreppe\DemandeTravauxBundle\Model\Travaux')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Travaux:index.html.twig', array(
            'entities' => $entities
        ));
    }
    
    public function ajouterAction()
    {
        return $this->render('MairieVoreppeDemandeTravauxBundle:Travaux:menu_ajouter_travaux.html.twig');
    }
}
