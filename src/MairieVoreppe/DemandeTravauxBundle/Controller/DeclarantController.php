<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeclarantController extends Controller
{
    public function indexAction()
    {        
         $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('\MairieVoreppe\DemandeTravauxBundle\Model\Declarant')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Declarant:index.html.twig', array(
            'entities' => $entities
        ));
    }
    
    
    public function ajouterAction()
    {
        return $this->render('MairieVoreppeDemandeTravauxBundle:Declarant:menu_ajouter_declarant.html.twig');
    }
}
