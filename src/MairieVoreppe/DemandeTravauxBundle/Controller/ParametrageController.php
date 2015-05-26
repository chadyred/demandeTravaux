<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * ParametrageController
 *
 */
class ParametrageController extends Controller
{

    /**
     * Gestion du cas où plusieurs services existes, et qu'il faut alors préciser dans celui dont on procède
     *
     */
    public function choixServiceNewAction()
    {        
        $form = $this->createFormChoixService();
        
        return $this->render('MairieVoreppeDemandeTravauxBundle:MultiService:parametrage_service.html.twig', array(
            'form_service'   => $form->createView(),
        ));
    }
    
     /**
     * Deletes a ATUrgent entity.
     *
     */
    public function choixServiceAction(Request $request)
    {
        $form = $this->createFormChoixService();
        $form->handleRequest($request);      
        

        if ($form->isValid()) {
            //Récupérer le service choisie avec son id du choix !
            $id = $form->get('service')->getData()->getId();
            $em = $this->getDoctrine()->getManager();

            $service = $em->getRepository('MairieVoreppeUserBundle:Service')->find($id);


            if (!$service) {
                throw $this->createNotFoundException('Unable to find Service entity.');
            }
        
            $session = $this->getRequest()->getSession();
            $this->get('session')->set('service', $service);            
            $this->get('session')->set('just_login', false);     
        }
        
        
        $redirection = $this->redirect($this->generateUrl('mairie_voreppe_demande_travaux_homepage'));
        
        return $redirection;
    }

    private function createFormChoixService(){   
        
        
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mairie_voreppe_security_parametrage_service_create'))
            ->setMethod('POST')
            ->add('service', 'entity', array('class' => 'MairieVoreppeUserBundle:Service',
                'query_builder' => function (\MairieVoreppe\UserBundle\Entity\ServiceRepository $repository)
                {
                    return $repository->createQueryBuilder('s')->join('s.users', 'u')->where('u.id = ' . $this->getUser()->getId());

                })) 
            ->add('submit', 'submit', array('label' => 'Valider'))
            ->getForm();
    }
   
}
