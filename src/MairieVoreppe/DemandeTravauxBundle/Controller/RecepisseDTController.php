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
class RecepisseDTController extends Controller
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
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
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

        $form->add('submit', 'submit', array('label' => 'Create'));

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

        $entity->getReponse()[0]->setClass(get_class($entity->getReponse()[0]));
        $reponse_recepisse_serialize = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('reponse_recepisse')));


        $entity->getReponse()[0]->setClass(get_class($entity->getRendezVous()[0]));
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

        $form->add('submit', 'submit', array('label' => 'Update'));

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

        $entity->getReponse()[0]->setClass(get_class($entity->getReponse()[0]));
        $reponse_recepisse_serialize = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('reponse_recepisse')));


        $entity->getReponse()[0]->setClass(get_class($entity->getRendezVous()[0]));
        $rendezvous_recepisse_serialize = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('rendezvous_recepisse')));
        

        if ($editForm->isValid()) {
            
            //Seule solution trouvée : pas de mapping pour les champs reponse et rendez-vous sans quoi en remplacant sa structure attendun on aura une erreur/
            //si une réponse est donné on met à jour celle-ci sinon on ne touche rien
            $reponse = $editForm->get('reponse')->getData();
            $rdv = $editForm->get('rendezVous')->getData();

            if($reponse != null) {
                $ancienneReponse =  $entity->getReponse();
                $em->remove($ancienneReponse[0]);
                 $entity->setReponse($reponse);
            }

            if($rdv != null) {
                 $ancienneRdv =  $entity->getRendezVous();
                $em->remove($ancienneRdv[0]);
                 $entity->setRendezVous($rdv);
            }

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
}
