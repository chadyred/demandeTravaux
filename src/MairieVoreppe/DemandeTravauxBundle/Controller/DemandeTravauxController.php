<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux;
use MairieVoreppe\DemandeTravauxBundle\Form\DemandeTravauxType;

/**
 * DemandeTravaux controller.
 *
 */
class DemandeTravauxController extends Controller
{

    /**
     * Lists all DemandeTravaux entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeTravaux')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:DemandeTravaux:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DemandeTravaux entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DemandeTravaux();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            //Persistance des adresse qui ne se fond pas en cascade
            foreach($entity->getAdresses() as $uneAdresse)
            {
                $uneAdresse->setTravaux($entity);
                $em->persist($uneAdresse);
            }
            
            //Si l'utilisateur à plusieurs service, il a du en choisir un après s'être connecté, il faut alors récupérer celui-ci sinon on récupère son unique service
            if(count($this->getUser()->getServices()) > 1)
            {
                 $serviceId = $this->get('session')->get('service')->getId();
                 $service = $em->getRepository('MairieVoreppeUserBundle:Service')->find($serviceId);


                if (!$service) {
                    throw $this->createNotFoundException('Unable to find Service entity.');
                }
                 
            }
            else
            {
                $service = $this->getUser()->getServices()->get(0);
            }
            
            $entity->setUser($this->getUser());
            $entity->setService($service);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('demandetravaux_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:DemandeTravaux:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DemandeTravaux entity.
     *
     * @param DemandeTravaux $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DemandeTravaux $entity)
    {
        $form = $this->createForm(new DemandeTravauxType(), $entity, array(
            'action' => $this->generateUrl('demandetravaux_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DemandeTravaux entity.
     *
     */
    public function newAction()
    {
        $entity = new DemandeTravaux();
        $form   = $this->createCreateForm($entity);
        
        return $this->render('MairieVoreppeDemandeTravauxBundle:DemandeTravaux:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DemandeTravaux entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeTravaux')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandeTravaux entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:DemandeTravaux:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DemandeTravaux entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeTravaux')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandeTravaux entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:DemandeTravaux:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DemandeTravaux entity.
    *
    * @param DemandeTravaux $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DemandeTravaux $entity)
    {
        $form = $this->createForm(new DemandeTravauxType(), $entity, array(
            'action' => $this->generateUrl('demandetravaux_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DemandeTravaux entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeTravaux')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DemandeTravaux entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
      
            
            //Persistance des adresse qui ne se fond pas en cascade
            foreach($entity->getAdresses() as $uneAdresse)
            {
                $uneAdresse->setTravaux($entity);
                $em->persist($uneAdresse);
            }
            
            //On va mettre le numéro de téléservice à jour de la DICT lié si il y a en a une bien évidemment
            // Rappel : une DT_DICT lié doit avoir le même numéro
            if(count($entity->getDicts()) > 0){
                foreach($entity->getDicts() as $dict)
                {
                    if($dict->getDtDictConjointe())
                        $dict->setNumeroTeleservice($entity->getNumeroTeleservice());
                }
            }
            
            
            //La suppression d'une adresse s'effectuera ici, après la persistence des éventuelle nouvelle créée
            if(count($entity->getAdresses()) > 0)
            {
                //On parcours les période sur le fomulaulaire.
                foreach($editForm->get('adresses') as $adress)
                {
                    
                    //Si un des bouttons de l'une d'entre elle est cliqué, cela déclanchera le submit du formulaire, c'est pourquoi on atterira dans cette action
                    //du controller. On va regarder si un des boutton a été cliquer. Pour cela on va vérifier tous ceux présent sur le formulaire en cours.
                    //Le boutton peut ne pas exister si l'adresse est la première adresse. Cependant, 'isset' ne peut vérifier que les variable et non ce que retourne les fonctions
                    //on ne peut pas vérifier alors 'if(isset($adress->get('delete')) == TRUE' (même sans le TRUE)
                    if(isset($adress["delete"]) && $adress->get('delete')->isClicked())
                    {
                        
                        //Le DRY ne marche pas pour la OneToMany.
                        //On récupère les données qui sont derrière l'instance de la structure parmis les adressses, et plus particulièrement
                        //l'identifiant de la période du bouton
                        $idAdresseBoutonDeleteClique = $adress->getData()->getId();
                        
                        //On récupère l'entité lié à cette id
                        $adress = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Adresse')->find($idAdresseBoutonDeleteClique);   
                        
                        //On la supprime.
                        $em->remove($adress);
                    }
                }          
            }
            
            
              //La suppression d'un contact urgent s'effectuera ici, après la persistence des éventuelle nouvelle créée
            if(count($entity->getContactsUrgent()) > 0)
            {
                //On parcours les période sur le fomulaulaire.
                foreach($editForm->get('contactsUrgent') as $cu)
                {
                    
                    //Si un des bouttons de l'une d'entre elle est cliqué, cela déclanchera le submit du formulaire, c'est pourquoi on atterira dans cette action
                    //du controller. On va regarder si un des boutton a été cliquer. Pour cela on va vérifier tous ceux présent sur le formulaire en cours.
                    //Le boutton peut ne pas exister si l'adresse est la première adresse. Cependant, 'isset' ne peut vérifier que les variable et non ce que retourne les fonctions
                    //on ne peut pas vérifier alors 'if(isset($adress->get('delete')) == TRUE' (même sans le TRUE)
                    if(isset($cu["delete"]) && $cu->get('delete')->isClicked())
                    {
                        //On récupère les données qui sont derrière l'instance de la structure parmis les adressses
                        $entity->removeContactsUrgent($cu->getData());
                    }
                }          
            }
            
            $em->flush();

            return $this->redirect($this->generateUrl('demandetravaux_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:DemandeTravaux:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DemandeTravaux entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeTravaux')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DemandeTravaux entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('demandetravaux'));
    }

    /**
     * Creates a form to delete a DemandeTravaux entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demandetravaux_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
