<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT;
use MairieVoreppe\DemandeTravauxBundle\Form\RecepisseDTType;
use MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux;
use JMS\Serializer\SerializationContext;

/**
 * RecepisseDT controller.
 *
 */
class RecepisseDTController extends RecepisseController
{

    /**
     * Lists all RecepisseDT entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        
        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDT')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDT:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new RecepisseDT entity.
     *
     */
    public function createAction(Request $request, $id_dt)
    {

       $em = $this->getDoctrine()->getManager();

        //Je récupère la dict à laquelle le récépissé est lié
        $dt = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeTravaux')->find($id_dt);

        if (!$dt) {
            throw $this->createNotFoundException('Unable to find DemandeTravaux entity.');
        }

        $entity = new RecepisseDT();
        $form = $this->createCreateForm($entity, $dt);
        $form->handleRequest($request);

        if ($form->isValid()) {

             $this->get('session')->getFlashBag()->add('notice', 'Confirmation de l\'ajout du récépissé');

               //On écitdateReceptionDemandee de ce répéter: on a une persistence automatique (DRY)
            $dt->setRecepisseDt($entity);

           $eros = $entity->getEmplacementsReseauOuvrage();

            //Une persistence qui ne se pas automatiquement...bizarre...
            foreach($eros as $ero){
                $entity->addEmplacementsReseauOuvrage($ero);
            }


            $reponse = $form->get('reponse')->getData();
            $entity->setReponse($reponse);

            $dt->setDateReponseDemande($entity->getDateCreation());
            

            //Ne ce perssiste une nouvelle fois pas tout le temps...peut être du au fait qu'il faille le faire dans une entité concrête et non abstraite?
            foreach($entity->getEmplacementsReseauOuvrage() as $ero)
                $entity->addEmplacementsReseauOuvrage($ero);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('recepissedt_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDT:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'dt' => $dt
        ));
    }

    /**
     * Creates a form to create a RecepisseDT entity.
     *
     * @param RecepisseDT $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RecepisseDT $entity,  DemandeTravaux $dt)
    {
        $form = $this->createForm(new RecepisseDTType(), $entity, array(
            'action' => $this->generateUrl('recepissedt_create', array('id_dt' => $dt->getId() )),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer !'));

        return $form;
    }

    /**
     * Displays a form to create a new RecepisseDT entity.
     *
     */
    public function newAction($id_dt)
    {
        $entity = new RecepisseDT();

        $em = $this->getDoctrine()->getManager();

        //Je récupère la dict à laquelle le récépissé est lié
        $dt = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeTravaux')->find($id_dt);

        if (!$dt) {
            throw $this->createNotFoundException('Unable to find DemandeIntentionCT entity.');
        }



        $form   = $this->createCreateForm($entity, $dt);

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDT:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'dt' => $dt
        ));
    }

    /**
     * Finds and displays a RecepisseDT entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepisseDT entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDT:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'dt' => $entity->getDt()
        ));
    }

    /**
     * Displays a form to edit an existing RecepisseDT entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepisseDT entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);


         /**
        * Sérialisation de la réponse et du rendez vous nécessaire afin d'enrichir les prototypes: 
        * - lorsque l'on charge l'édition
        * TODO - lorsque l'on change et que l'on revien sur le type de base
        */
        $serializer = $this->get('jms_serializer');

        if($entity->getReponse()[0] != null)
            $entity->getReponse()[0]->setClass(get_class($entity->getReponse()[0]));

        $reponse_recepisse_serialize = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('reponse_recepisse')));


        if($entity->getRendezVous()[0] != null)
            $entity->getRendezVous()[0]->setClass(get_class($entity->getRendezVous()[0]));

        $rendezvous_recepisse_serialize = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('rendezvous_recepisse')));

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDT:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'reponse_recepisse_serialize' => $reponse_recepisse_serialize,
            'rendezvous_recepisse_serialize' => $rendezvous_recepisse_serialize,
            'dt' => $entity->getDt()
       ));
    }

    /**
    * Creates a form to edit a RecepisseDT entity.
    *
    * @param RecepisseDT $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RecepisseDT $entity)
    {
        $form = $this->createForm(new RecepisseDTType(), $entity, array(
            'action' => $this->generateUrl('recepissedt_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing RecepisseDT entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepisseDT entity.');
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

        if($entity->getRendezVous()[0] != null)
            $entity->getRendezVous()[0]->setClass(get_class($entity->getRendezVous()[0]));

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


            return $this->redirect($this->generateUrl('recepissedt_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDT:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'reponse_recepisse_serialize' => $reponse_recepisse_serialize,
            'rendezvous_recepisse_serialize' => $rendezvous_recepisse_serialize,
            'dt' => $entity->getDt()
        ));
    }
    /**
     * Deletes a RecepisseDT entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDT')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RecepisseDT entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('recepissedt'));
    }

    /**
     * Creates a form to delete a RecepisseDT entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recepissedt_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function genererRecepisseDTAction(Request $request, $id)
    {
         $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:RecepisseDT')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepisseDT entity.');
        }
        
        $entityDt = $entity->getDt();
        

       $this->generationFullPdfExemple($entityDt);  
    }

}
