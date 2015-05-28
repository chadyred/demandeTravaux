<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Model\Recepisse;
use MairieVoreppe\DemandeTravauxBundle\Form\RecepisseType;

/**
 * Recepisse controller.
 *
 */
class RecepisseController extends Controller
{

    /**
     * Lists all Recepisse entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('\MairieVoreppe\DemandeTravauxBundle\Model\Recepisse')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Recepisse:index.html.twig', array(
            'entities' => $entities,
        ));
    }
  
}
