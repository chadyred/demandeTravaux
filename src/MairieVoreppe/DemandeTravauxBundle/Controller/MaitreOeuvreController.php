<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaitreOeuvreController extends Controller
{
    public function indexAction()
    {        
         $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('\MairieVoreppe\DemandeTravauxBundle\Model\MaitreOeuvre')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:MaitreOeuvre:index.html.twig', array(
            'entities' => $entities
        ));
    }
    
    
    public function ajouterAction()
    {
        return $this->render('MairieVoreppeDemandeTravauxBundle:MaitreOeuvre:menu_ajouter_maitre_oeuvre.html.twig');
    }
}
