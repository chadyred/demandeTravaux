<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\Civil;
use MairieVoreppe\DemandeTravauxBundle\Form\CivilType;

/**
 * Civil controller.
 *
 */
class CivilController extends Controller
{

    /**
     * Lists all Civil entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Civil')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Civil:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Civil entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Civil();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('civil_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:Civil:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Civil entity.
     *
     * @param Civil $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Civil $entity)
    {
        $form = $this->createForm(new CivilType(), $entity, array(
            'action' => $this->generateUrl('civil_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer !'));

        return $form;
    }

    /**
     * Displays a form to create a new Civil entity.
     *
     */
    public function newAction()
    {
        $entity = new Civil();
        $form   = $this->createCreateForm($entity);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Civil:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Civil entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Civil')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Civil entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Civil:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Civil entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Civil')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Civil entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Civil:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Civil entity.
    *
    * @param Civil $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Civil $entity)
    {
        $form = $this->createForm(new CivilType(), $entity, array(
            'action' => $this->generateUrl('civil_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing Civil entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Civil')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Civil entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('civil_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:Civil:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Civil entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Civil')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Civil entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('civil'));
    }

    /**
     * Creates a form to delete a Civil entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('civil_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
