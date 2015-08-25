<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\Periode;
use MairieVoreppe\DemandeTravauxBundle\Form\PeriodeType;
use MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant;
use MairieVoreppe\DemandeTravauxBundle\Entity\Maire;

/**
 * Periode controller.
 *
 */
class PeriodeController extends Controller
{
    /**
     * Lists Periode within a Mairie.
     *
     */
    public function indexByExploitantAction(Exploitant $exploitant)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Periode')->myFindByExploitant($exploitant->getId());

        return $this->render('MairieVoreppeDemandeTravauxBundle:Periode:index_by_exploitant.html.twig', array(
            'entities' => $entities,
            'exploitant' => $exploitant
        ));
    }
    
    
    /**
     * Creates a new Periode entity.
     *
     */
    public function createAction(Request $request, Exploitant $exploitant)
    {
        $entity = new Periode();
                
        $form = $this->createCreateForm($entity, $exploitant);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
                      
            //On eprsiste le maire dans un premier temps
            $responsableExploitant = $entity->getResponsableExploitant();            
            $em->persist($responsableExploitant);
            $em->flush();
            
            //Puis la période ensuite afin que l'id du maire soit ciblable
            $exploitant->addPeriode($entity);            
            $em->flush();

            return $this->redirect($this->generateUrl('responsable_exploitant_show', array('id' => $exploitant->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:Periode:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Periode entity.
     *
     * @param Periode $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Periode $entity, Exploitant $exploitant)
    {
        $form = $this->createForm(new PeriodeType($exploitant), $entity, array(
            'action' => $this->generateUrl('periode_create', array('id' => $exploitant->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer !'));

        return $form;
    }

    /**
     * Displays a form to create a new Periode entity.
     *
     */
    public function newAction(Exploitant $exploitant)
    {
        $entity = new Periode();
        $form   = $this->createCreateForm($entity, $exploitant);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Periode:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'exploitant' => $exploitant
        ));
    }

    /**
     * Finds and displays a Periode entity.
     *
     */
    public function showAction($id, Exploitant $exploitant)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Periode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Periode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Periode:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Periode entity.
     *
     */
    public function editAction($id, Exploitant $exploitant)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Periode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Periode entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Periode:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Periode entity.
    *
    * @param Periode $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Periode $entity)
    {
        $form = $this->createForm(new PeriodeType(), $entity, array(
            'action' => $this->generateUrl('periode_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing Periode entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Periode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Periode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $em->flush();

            return $this->redirect($this->generateUrl('periode_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:Periode:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
   
    //La suppression des période se faire dans l'update d'un maire, au sein de son controller
}
