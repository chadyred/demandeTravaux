<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\DtDict;
use MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT;
use MairieVoreppe\DemandeTravauxBundle\Form\DtDictType;
use Symfony\Component\HttpFoundation\Response;

/**
 * DtDict controller. 
 * 
 * Ce controller traduit l'état d'une DICT lorsque cele-ci est lié à une DT et ainsi on factorise au maximum.
 * Tous le code ici présent aurait pu se mettre au sein du controller dict.
 *
 */
class DtDictController extends Controller
{

    /**
     * Lists all DtDict entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeIntentionCT')->findBy(array('dtDictConjointe' => true));

        return $this->render('MairieVoreppeDemandeTravauxBundle:DtDict:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DtDict entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DemandeIntentionCT();
        $form = $this->createCreateForm($entity, $this->getUser());
        $form->handleRequest($request);
        
            
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $dt = $entity->getDt();          
            
            //On affecte le même numéro de dt à celui de la DICT
            $entity->setNumeroTeleservice($dt->getNumeroTeleservice());
            
            var_dump(count($entity->getAdresses()));
            // Les adresses ne se persiste toujours pas avec la DICT. Si aucune information n'est saisie avec un type collection, les données ne seront pas
            //persisté
            if(count($entity->getAdresses()) > 0)
            {
                foreach($entity->getAdresses() as $adress)
                {
                    $entity->addAdress($adress);
                    $em->persist($adress);
                }
            }
            
         
            
            //L'utilisateur qui créer le travaux lui est lié
            $dt->setUser($this->getUser());
            $entity->setUser($this->getUser());
            
            $em->persist($dt);            
            $em->persist($entity);
            
            
            $em->flush();
            
            //En pre persist, les dt et dict possède également comme entity inverse la dtdict
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dtdict_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:DtDict:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DtDict entity.
     *
     * @param DtDict $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DemandeIntentionCT $entity, $user)
    {
        $form = $this->createForm(new DtDictType($user), $entity, array(
            'action' => $this->generateUrl('dtdict_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DtDict entity.
     *
     */
    public function newAction()
    {
        //On récupère l'utilisateur en cours
        $user = $this->getUser();
        $entity = new DemandeIntentionCT();
        $form   = $this->createCreateForm($entity, $user);

        return $this->render('MairieVoreppeDemandeTravauxBundle:DtDict:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DtDict entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeIntentionCT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DtDict entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:DtDict:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DtDict entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeIntentionCT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DtDict entity.');
        }
        
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        return $this->render('MairieVoreppeDemandeTravauxBundle:DtDict:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

   /**
    * Creates a form to edit a DtDict entity.
    *
    * @param DtDict $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DemandeIntentionCT $entity)
    {
        $form = $this->createForm(new DtDictType(), $entity, array(
            'action' => $this->generateUrl('dtdict_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DtDict entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        //On récupère la DICT créé
        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeIntentionCT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DtDict entity.');
        }
        
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        
        //editForm possédera l'ensemble des information de la dict
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            //On récupère les instance hydratée
            $dt = $entity->getDt();
            
            //Pour plus de clareté, on définis l'entiy dans une variable nommée dict
            $dict = $entity;
            
            //On récupère la structure du formulaire pour nos DT et nos DICT
            $editFormDt = $editForm->get('dt');                    
            
            //On affecte le même numéro de dt à celui de la DICT
            $dict->setNumeroTeleservice($dt->getNumeroTeleservice());
            
            var_dump("Dict adressse" . count($dict->getAdresses()));
             //Les adresse ne se persiste toujours pas avec la DICT et il se peut qu'il y en est pas non plus 
            if(count($dict->getAdresses()) > 0)
            {
                foreach($dict->getAdresses() as $adress)
                {
                    $dict->addAdress($adress);
                    $em->persist($adress);
                }
            }


            var_dump("Dt adressse" . count($dt->getAdresses()));
            
            //Les adresse ne se persiste toujours pas avec la DT et il se peut qu'il y en est pas non plus 
            if(count($dt->getAdresses()) > 0)
            {
                 //Les adresse ne se persiste toujours pas avec la DT
                foreach($dt->getAdresses() as $adress)
                {
                    $dt->addAdress($adress);
                    $em->persist($adress);
                }
            }
            
            //La suppression d'une adresse s'effectuera ici, après la persistence des éventuelle nouvelle créées
            if(count($dict->getAdresses()) > 0)
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
            
             //La suppression d'une adresse s'effectuera ici, après la persistence des éventuelle nouvelle créée
            if(count($dict->getAdresses()) > 0)
            {
                //On parcours les période sur le fomulaulaire.
                foreach($editFormDt->get('adresses') as $adress)
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
            if(count($dt->getContactsUrgent()) > 0)
            {
                //On parcours les période sur le fomulaulaire.
                foreach($editFormDt->get('contactsUrgent') as $cu)
                {
                    
                    //Si un des bouttons de l'une d'entre elle est cliqué, cela déclanchera le submit du formulaire, c'est pourquoi on atterira dans cette action
                    //du controller. On va regarder si un des boutton a été cliquer. Pour cela on va vérifier tous ceux présent sur le formulaire en cours.
                    //Le boutton peut ne pas exister si l'adresse est la première adresse. Cependant, 'isset' ne peut vérifier que les variable et non ce que retourne les fonctions
                    //on ne peut pas vérifier alors 'if(isset($adress->get('delete')) == TRUE' (même sans le TRUE)
                    if(isset($cu["delete"]) && $cu->get('delete')->isClicked())
                    {
                        //On récupère les données qui sont derrière l'instance de la structure parmis les adressses
                        $dt->removeContactsUrgent($cu->getData());
                    }
                }          
            }
            
            //La suppression d'un contact urgent s'effectuera ici, après la persistence des éventuelle nouvelle créée
            if(count($dict->getContactsUrgent()) > 0)
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
                        $dict->removeContactsUrgent($cu->getData());
                    }
                }          
            }
            
            $em->flush();

            return $this->redirect($this->generateUrl('dtdict_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:DtDict:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a DtDict entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DtDict')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DtDict entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dtdict'));
    }

    /**
     * Creates a form to delete a DtDict entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dtdict_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
