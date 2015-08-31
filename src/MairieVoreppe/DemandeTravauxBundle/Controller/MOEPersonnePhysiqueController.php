<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonnePhysique;
use MairieVoreppe\DemandeTravauxBundle\Form\MOEPersonnePhysiqueType;
use MairieVoreppe\DemandeTravauxBundle\Entity\Civil;
/**
 * MOEPersonnePhysique controller.
 *
 */
class MOEPersonnePhysiqueController extends Controller
{

    /**
     * Lists all MOEPersonnePhysique entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MOEPersonnePhysique entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new MOEPersonnePhysique();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('moepersonnephysique_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MOEPersonnePhysique entity.
     *
     * @param MOEPersonnePhysique $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MOEPersonnePhysique $entity)
    {
        $form = $this->createForm(new MOEPersonnePhysiqueType(), $entity, array(
            'action' => $this->generateUrl('moepersonnephysique_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer !'));

        return $form;
    }

    /**
     * Displays a form to create a new MOEPersonnePhysique entity.
     *
     */
    public function newAction()
    {
        $entity = new MOEPersonnePhysique();
        $form   = $this->createCreateForm($entity);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Finds and displays a MOEPersonnePhysique entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOEPersonnePhysique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MOEPersonnePhysique entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOEPersonnePhysique entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MOEPersonnePhysique entity.
    *
    * @param MOEPersonnePhysique $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MOEPersonnePhysique $entity)
    {        
            
        $form = $this->createForm(new MOEPersonnePhysiqueType(), $entity, array(
            'action' => $this->generateUrl('moepersonnephysique_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing MOEPersonnePhysique entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MOEPersonnePhysique entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('moepersonnephysique_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MOEPersonnePhysique entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:MOEPersonnePhysique')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MOEPersonnePhysique entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('moepersonnephysique'));
    }

    /**
     * Creates a form to delete a MOEPersonnePhysique entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('moepersonnephysique_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer', "attr" => array("class" => "btn btn-danger")))
            ->getForm()
        ;
    }
}
