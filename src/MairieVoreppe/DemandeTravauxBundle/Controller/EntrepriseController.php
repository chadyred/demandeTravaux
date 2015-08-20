<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise;
use MairieVoreppe\DemandeTravauxBundle\Form\EntrepriseType;

/**
 * Entreprise controller.
 *
 */
class EntrepriseController extends Controller
{

    /**
     * Lists all Entreprise entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //On récupère les entreprise qui ne sont pas MOE et les MOE qui sont également apt à faire des DICTs.
        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Entreprise')->myFindAllEntreprise();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Entreprise:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    /**
     * Creates a new Entreprise entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Entreprise();

        //True indique que l'on créé une véritable entreprise et non en passant par un déclarant, ce en vue de cacher la case à coché étant donné
        //qu'elle l'est directement
        $form = $this->createCreateForm($entity, true);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setPrestataireDICT(true);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entreprise_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:Entreprise:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Entreprise entity.
     *
     * @param Entreprise $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Entreprise $entity, $entrepriseDict)
    {
        $form = $this->createForm(new EntrepriseType($entrepriseDict), $entity, array(
            'action' => $this->generateUrl('entreprise_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Entreprise entity.
     *
     */
    public function newAction()
    {
        $entity = new Entreprise();
        
        //True indique que l'on créé une véritable entreprise et non en passant par un déclarant, ce en vue de cacher la case à coché étant donné
        //qu'elle l'est directement
        $form   = $this->createCreateForm($entity, true);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Entreprise:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Entreprise entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Entreprise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entreprise entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Entreprise:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Entreprise entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Entreprise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entreprise entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Entreprise:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Entreprise entity.
    *
    * @param Entreprise $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entreprise $entity)
    {
        $form = $this->createForm(new EntrepriseType(), $entity, array(
            'action' => $this->generateUrl('entreprise_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Entreprise entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Entreprise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entreprise entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('entreprise_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:Entreprise:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Entreprise entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Entreprise')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entreprise entity.');
            }

            if($entity->getMoePersonneMorale() != null)
            {   
                $moePersonneMorale = $entity->getMoePersonneMorale();
                $moePersonneMorale->setEntreprise(null);
                $em->flush();
                $em->remove($moePersonneMorale);
                $em->remove($entity);
                $em->flush();
            }
            else
            {       
                $em->remove($entity);
                $em->flush();
            }

        }

        return $this->redirect($this->generateUrl('entreprise'));
    }

    /**
     * Creates a form to delete a Entreprise entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entreprise_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
