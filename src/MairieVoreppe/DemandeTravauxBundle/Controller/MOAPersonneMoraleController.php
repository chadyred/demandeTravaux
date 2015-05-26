<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonneMorale;
use MairieVoreppe\DemandeTravauxBundle\Form\MOAPersonneMoraleEntrepriseType;

/**
 * MOAPersonneMorale controller.
 *
 * Une MOA en tant que personne morale pourrait être une association, une entreprise.. ce polymorphisme est alors ç prendre en compte en ajoutant les 
 * action nécessaire puis un formulaire selon la forme demandée, tel que pour l'entreprise, le formulaire devra contenir l'ajout d'une entreprise, 
 * il en va de même pour une association par exemple
 * 
 */
class MOAPersonneMoraleController extends Controller
{

    /**
     * Lists all MOAPersonneMorale entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MOAPersonneMorale entity.
     *
     */
    public function createMOAEntrepriseAction(Request $request)
    {
        $entity = new MOAPersonneMorale();
        $form = $this->createCreateMOAEntrepriseForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('moapersonnemorale_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

        /**
     * Creates a form to create a MOAPersonneMorale entity.
     *
     * @param MOAPersonneMorale $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateMOAEntrepriseForm(MOAPersonneMorale $entity)
    {
        $form = $this->createForm(new MOAPersonneMoraleEntrepriseType(), $entity, array(
            'action' => $this->generateUrl('moapersonnemorale_create_entreprise'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MOAPersonneMorale entity.
     *
     */
    public function newMOAEntrepriseAction()
    {
        $entity = new MOAPersonneMorale();
        $form   = $this->createCreateMOAEntrepriseForm($entity);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MOAPersonneMorale entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOAPersonneMorale entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /***************************************************
     *
     *  Gestion des action du polymorphisme des personne morale de la maitrise d'ouvrage
     * 
     */
    /**
     * Displays a form to edit an existing MOAPersonneMorale entity.
     *
     */
    public function editMOAEntrepriseAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOAPersonneMorale entity.');
        }

        $editForm = $this->createMOAEntrepriseEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MOAPersonneMorale entity.
    *
    * @param MOAPersonneMorale $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createMOAEntrepriseEditForm(MOAPersonneMorale $entity)
    {         
        
        $form = $this->createForm(new MOAPersonneMoraleEntrepriseType($villeCp), $entity, array(
            'action' => $this->generateUrl('moapersonnemorale_update_entreprise', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MOAPersonneMorale entity.
     *
     */
    public function updateMOAEntrepriseAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOAPersonneMorale entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createMOAEntrepriseEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('moapersonnemorale_edit_entreprise', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MOAPersonneMorale entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOAPersonneMorale')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MOAPersonneMorale entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('moapersonnemorale'));
    }

    /**
     * Creates a form to delete a MOAPersonneMorale entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('moapersonnemorale_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
