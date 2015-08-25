<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICT;
use MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT;
use MairieVoreppe\DemandeTravauxBundle\Form\RecepisseDICTType;
use JMS\Serializer\SerializationContext;

/**
 * RecepisseDICT controller.
 *
 */
class RecepisseDICTController extends RecepisseController
{

    /**
     * Lists all RecepisseDICT entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDICT')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDICT:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new RecepisseDICT entity.
     *
     */
    public function createAction(Request $request, $id_dict)
    {
         $em = $this->getDoctrine()->getManager();

        //Je récupère la dict à laquelle le récépissé est lié
        $dict = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeIntentionCT')->find($id_dict);

        if (!$dict) {
            throw $this->createNotFoundException('Unable to find DemandeIntentionCT entity.');
        }

        //On indique la DICT que l'on désire récupérer
        $entity = new RecepisseDICT();

        $form = $this->createCreateForm($entity, $dict);

        $form->handleRequest($request);

        if ($form->isValid()) {

             $this->get('session')->getFlashBag()->add('notice', 'Confirmation de l\'ajout du récépissé');

            $eros = $entity->getEmplacementsReseauOuvrage();


            $dict->setRecepisseDict($entity);
        

            //Une persistence qui ne se pas automatiquement...bizarre...
            foreach($eros as $ero){
                $entity->addEmplacementsReseauOuvrage($ero);
            }

            /**
            *
            * Ces deux élément sont des entité polymorphique. Symfony le gère au travers d'une bundle. ependant celui-ci créé un type de base, alors que l'on a 
            * une OneToOne, ce type peut alors être modifier.
            */
            $reponse = $form->get('reponse')->getData();
            $entity->setReponse($reponse);



            $reponse = $form->get('rendezVous')->getData();
            $entity->setRendezVous($reponse);
            
            $dict->setDateReponseDemande($entity->getDateCreation());

            
            //Ne ce perssiste une nouvelle fois pas tout le temps...peut être du au fait qu'il faille le faire dans une entité concrête et non abstraite?
            foreach($entity->getEmplacementsReseauOuvrage() as $ero)
                $entity->addEmplacementsReseauOuvrage($ero);

            $em->flush();

            return $this->redirect($this->generateUrl('recepissedict_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDICT:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'dict' => $dict
        ));
    }

    /**
     * Creates a form to create a RecepisseDICT entity.
     *
     * @param RecepisseDICT $entity The entity
     *271
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RecepisseDICT $entity, DemandeIntentionCT $dict)
    {
        $form = $this->createForm(new RecepisseDICTType(), $entity, array(
            'action' => $this->generateUrl('recepissedict_create', array('id_dict' => $dict->getId() )),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer !'));

        return $form;
    }

    /**
     * Displays a form to create a new RecepisseDICT entity.
     *
     */
    public function newAction($id_dict)
    {
        $em = $this->getDoctrine()->getManager();

        //Je récupère la dict à laquelle le récépissé est lié
        $dict = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeIntentionCT')->find($id_dict);

        if (!$dict) {
            throw $this->createNotFoundException('Unable to find DemandeIntentionCT entity.');
        }

        $entity = new RecepisseDICT();
        $form   = $this->createCreateForm($entity, $dict);


        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDICT:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'dict'   => $dict
        ));
    }

    /**
     * Finds and displays a RecepisseDICT entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDICT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepisseDICT entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDICT:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RecepisseDICT entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDICT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepisseDICT entity.');
        }



        $serializer = $this->get('jms_serializer');

         /**
         * Sérialisation de la réponse et du rendez vous nécessaire afin d'enrichir les prototypes: 
         * - lorsque l'on charge l'édition
         * TODO - lorsque l'on change et que l'on revien sur le type de base
         */       
        if($entity->getReponse()[0] != null)
            $entity->getReponse()[0]->setClass(get_class($entity->getReponse()[0]));

        $reponse_recepisse_serialize = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('reponse_recepisse')));

        //Si on a un rendez-vous on récupère le type de rendez vous hérité
        if($entity->getRendezVous()[0] != null){
            $entity->getRendezVous()[0]->setClass(get_class($entity->getRendezVous()[0]));
        }
        
        $rendezvous_recepisse_serialize = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('rendezvous_recepisse')));
        
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDICT:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dict' => $entity->getDict(),
            'reponse_recepisse_serialize' => $reponse_recepisse_serialize,
            'rendezvous_recepisse_serialize' => $rendezvous_recepisse_serialize
        ));
    }

    /**
    * Creates a form to edit a RecepisseDICT entity.
    *
    * @param RecepisseDICT $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RecepisseDICT $entity)
    {
        $form = $this->createForm(new RecepisseDICTType($entity), $entity, array(
            'action' => $this->generateUrl('recepissedict_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing RecepisseDICT entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDICT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepisseDICT entity.');
        }        
        


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
      
        /**
        * Sérialisation de la réponse et du rendez vous nécessaire afin d'enrichir les prototypes: 
        * - lorsque l'on charge l'édition
        * TODO - lorsque l'on change et que l'on revien sur le type de base
        */
        $serializer = $this->get('jms_serializer');


        if($entity->getReponse()[0] != null)
            $entity->getReponse()[0]->setClass(get_class($entity->getReponse()[0]));

        $reponse_recepisse_serialize = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('reponse_recepisse')));


        //Si on a un rendez-vous on récupère le type de rendez vous hérité
        if($entity->getRendezVous()[0] != null){
         $entity->getRendezVous()[0]->setClass(get_class($entity->getRendezVous()[0]));
        }
        
        $rendezvous_recepisse_serialize = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('rendezvous_recepisse')));
        

        if ($editForm->isValid()) {
            
            //Seule solution trouvée : pas de mapping pour les champs reponse et rendez-vous sans quoi en remplacant sa structure attendun on aura une erreur/
            //si une réponse est donné on met à jour celle-ci sinon on ne touche rien
            $reponse = $editForm->get('reponse')->getData();
            $rdv = $editForm->get('rendezVous')->getData();

            if($reponse != null) {
                $ancienneReponse =  $entity->getReponse();
                
                 if($ancienneReponse[0] != null)
                    $em->remove($ancienneReponse[0]);
                
                 $entity->setReponse($reponse);
            }

            if($rdv != null) {
                //On va supprimer le précédent rendez-vous parce que l'on bypass le Symfony-Way
                 $ancienRdv =  $entity->getRendezVous();

                 if($ancienRdv[0] != null)
                    $em->remove($ancienRdv[0]);

                 $entity->setRendezVous($rdv);
            }


            //Ne ce perssiste une nouvelle fois pas tout le temps...peut être du au fait qu'il faille le faire dans une entité concrête et non abstraite?
            foreach($entity->getEmplacementsReseauOuvrage() as $ero)
                $entity->addEmplacementsReseauOuvrage($ero);

            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Confirmation de l\'édition du récépissé');


            return $this->redirect($this->generateUrl('recepissedict_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDICT:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'dict' => $entity->getDict(),
            'reponse_recepisse_serialize' => $reponse_recepisse_serialize,
            'rendezvous_recepisse_serialize' => $rendezvous_recepisse_serialize
        ));
    }
    /**
     * Deletes a RecepisseDICT entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDICT')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RecepisseDICT entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('recepissedict'));
    }

    /**
     * Creates a form to delete a RecepisseDICT entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recepissedict_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

     public function genererRecepisseDICTAction(Request $request, $id)
    {
         $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDICT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepisseDICT entity.');
        }
        
        $entityDict = $entity->getDict();
        

       $this->generationFullPdfExemple($entityDict);  
    }


}
