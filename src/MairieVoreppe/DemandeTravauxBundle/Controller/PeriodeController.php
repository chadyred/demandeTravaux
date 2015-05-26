<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\Periode;
use MairieVoreppe\DemandeTravauxBundle\Form\PeriodeType;
use MairieVoreppe\DemandeTravauxBundle\Entity\Mairie;
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
    public function indexByMairieAction(Mairie $mairie)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Maire')->myFindByMairie($mairie->getId());

        return $this->render('MairieVoreppeDemandeTravauxBundle:Periode:index_by_mairie.html.twig', array(
            'entities' => $entities,
            'mairie' => $mairie
        ));
    }
    
    
    /**
     * Creates a new Periode entity.
     *
     */
    public function createAction(Request $request, Mairie $mairie)
    {
        $entity = new Periode();
                
        $form = $this->createCreateForm($entity, $mairie);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
                      
            //On eprsiste le maire dans un premier temps
            $maire = $entity->getMaire();            
            $em->persist($maire);
            $em->flush();
            
            //Puis la période ensuite afin que l'id du maire soit ciblable
            $mairie->addPeriode($entity);            
            $em->flush();

            return $this->redirect($this->generateUrl('maire_show', array('id' => $maire->getId())));
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
    private function createCreateForm(Periode $entity, Mairie $mairie)
    {
        $form = $this->createForm(new PeriodeType($mairie), $entity, array(
            'action' => $this->generateUrl('periode_create', array('id' => $mairie->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Periode entity.
     *
     */
    public function newAction(Mairie $mairie)
    {
        $entity = new Periode();
        $form   = $this->createCreateForm($entity, $mairie);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Periode:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'mairie' => $mairie
        ));
    }

    /**
     * Finds and displays a Periode entity.
     *
     */
    public function showAction($id, Mairie $mairie)
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
    public function editAction($id, Mairie $mairie)
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

        $form->add('submit', 'submit', array('label' => 'Update'));

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
