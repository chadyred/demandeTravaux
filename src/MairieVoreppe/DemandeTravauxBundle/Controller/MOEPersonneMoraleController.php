<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMorale;
use MairieVoreppe\DemandeTravauxBundle\Form\MOEPersonneMoraleType;

/**
 * MOEPersonneMorale controller.
 *
 * Une MOE est expclusivement une entreprise. Il est nul nécessaire d'ajouter des controleur répondant à un éventuel polymorphisme
 * 
 */
class MOEPersonneMoraleController extends Controller
{

    /**
     * Lists all MOEPersonneMorale entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MOEPersonneMorale entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new MOEPersonneMorale();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('moepersonnemorale_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MOEPersonneMorale entity.
     *
     * @param MOEPersonneMorale $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MOEPersonneMorale $entity)
    {
        $form = $this->createForm(new MOEPersonneMoraleType(), $entity, array(
            'action' => $this->generateUrl('moepersonnemorale_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MOEPersonneMorale entity.
     *
     */
    public function newAction()
    {
        $entity = new MOEPersonneMorale();
        $form   = $this->createCreateForm($entity);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MOEPersonneMorale entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOEPersonneMorale entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MOEPersonneMorale entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOEPersonneMorale entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MOEPersonneMorale entity.
    *
    * @param MOEPersonneMorale $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MOEPersonneMorale $entity)
    {
        
        //Nécessaire pour le formulaire d'adresse
        
        $form = $this->createForm(new MOEPersonneMoraleType(), $entity, array(
            'action' => $this->generateUrl('moepersonnemorale_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MOEPersonneMorale entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOEPersonneMorale entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('moepersonnemorale_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MOEPersonneMorale entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonneMorale')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MOEPersonneMorale entity.');
            }

            // LOrsque l'on supprime un maître do'euvre en tant que personne morale, une one to one entreprise existe. De chaque côté on a une clé étrangère afin de récupéré
            // du coté inverse, l'owner side. Sans cela une onetoone ne fonctionnerai pas lorsque l'on souhaite
            $entrepriseMoe = $entity->getEntreprise();
            $entity->setEntreprise(null);
            $em->flush();
            $em->remove($entrepriseMoe);
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('moepersonnemorale'));
    }

    /**
     * Creates a form to delete a MOEPersonneMorale entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('moepersonnemorale_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
