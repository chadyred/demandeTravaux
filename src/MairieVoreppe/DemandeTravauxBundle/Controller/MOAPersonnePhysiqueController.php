<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonnePhysique;
use MairieVoreppe\DemandeTravauxBundle\Form\MOAPersonnePhysiqueType;

/**
 * MOAPersonnePhysique controller.
 *
 */
class MOAPersonnePhysiqueController extends Controller
{

    /**
     * Lists all MOAPersonnePhysique entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MOAPersonnePhysique entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new MOAPersonnePhysique();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('moapersonnephysique_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MOAPersonnePhysique entity.
     *
     * @param MOAPersonnePhysique $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MOAPersonnePhysique $entity)
    {
        
        $form = $this->createForm(new MOAPersonnePhysiqueType(), $entity, array(
            'action' => $this->generateUrl('moapersonnephysique_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MOAPersonnePhysique entity.
     *
     */
    public function newAction()
    {
        $entity = new MOAPersonnePhysique();
        $form   = $this->createCreateForm($entity);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MOAPersonnePhysique entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOAPersonnePhysique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MOAPersonnePhysique entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOAPersonnePhysique entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MOAPersonnePhysique entity.
    *
    * @param MOAPersonnePhysique $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MOAPersonnePhysique $entity)
    {
        
        $form = $this->createForm(new MOAPersonnePhysiqueType(), $entity, array(
            'action' => $this->generateUrl('moapersonnephysique_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MOAPersonnePhysique entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOAPersonnePhysique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('moapersonnephysique_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MOAPersonnePhysique entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonnePhysique')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MOAPersonnePhysique entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('moapersonnephysique'));
    }

    /**
     * Creates a form to delete a MOAPersonnePhysique entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('moapersonnephysique_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
