<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaitreOuvrageController extends Controller
{
    public function indexAction()
    {        
         $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('\MairieVoreppe\DemandeTravauxBundle\Model\MaitreOuvrage')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:MaitreOuvrage:index.html.twig', array(
            'entities' => $entities
        ));
    }
    
    
    public function ajouterAction()
    {
        return $this->render('MairieVoreppeDemandeTravauxBundle:MaitreOuvrage:menu_ajouter_maitre_ouvrage.html.twig');
    }
}
