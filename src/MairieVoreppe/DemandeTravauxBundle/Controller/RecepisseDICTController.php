<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICT;
use MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT;
use MairieVoreppe\DemandeTravauxBundle\Form\RecepisseDICTType;

/**
 * RecepisseDICT controller.
 *
 */
class RecepisseDICTController extends Controller
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
            $em = $this->getDoctrine()->getManager();
            
            $dict->setRecepisseDict($entity);
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
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RecepisseDICT $entity, DemandeIntentionCT $dict)
    {
        $form = $this->createForm(new RecepisseDICTType(), $entity, array(
            'action' => $this->generateUrl('recepissedict_create', array('id_dict' => $dict->getId() )),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

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

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDICT:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $form = $this->createForm(new RecepisseDICTType(), $entity, array(
            'action' => $this->generateUrl('recepissedict_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

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

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('recepissedict_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:RecepisseDICT:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
}
