<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\ArretePromulgue;
use MairieVoreppe\DemandeTravauxBundle\Form\ArretePromulgueType;
use Symfony\Component\HttpFoundation\Response;

/**
 * ArretePromulgue controller.
 *
 */
class ArretePromulgueController extends Controller
{

    /**
     * Lists all ArretePromulgue entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArretePromulgue')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArretePromulgue:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ArretePromulgue entity.
     *
     */
    public function createAction(Request $request, $id_dict)
    {
         $em = $this->getDoctrine()->getManager();
        $entityDict = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeIntentionCT')->find($id_dict);

        if (!$entityDict) {
            throw $this->createNotFoundException('Unable to find dict entity.');
        }
        
        $entity = new ArretePromulgue();
        $form = $this->createCreateForm($entity, $entityDict);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('arretepromulgue_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArretePromulgue:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ArretePromulgue entity.
     *
     * @param ArretePromulgue $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ArretePromulgue $entity, $entityDict)
    {
        $form = $this->createForm(new ArretePromulgueType($entityDict), $entity, array(
            'action' => $this->generateUrl('arretepromulgue_create', array('id_dict' => $entityDict->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer !'));

        return $form;
    }

    /**
     * Displays a form to create a new ArretePromulgue entity.
     *
     */
    public function newAction($id_dict)
    {      
        $em = $this->getDoctrine()->getManager();
        $entityDict = $em->getRepository('MairieVoreppeDemandeTravauxBundle:DemandeIntentionCT')->find($id_dict);

        if (!$entityDict) {
            throw $this->createNotFoundException('Unable to find dict entity.');
        }
        
        $entity = new ArretePromulgue();
        $form   = $this->createCreateForm($entity, $entityDict);

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArretePromulgue:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

     /**
     * Finds and displays a ArretePromulgue entity.
     *
     */
    public function contenuAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArretePromulgue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArretePromulgue entity.');
        }
        
        $twig = clone $this->get('twig');
        $twig->setLoader(new \Twig_Loader_String());
        $renderedTemplate = $twig->render($entity->getArreteModel()->getContenu(), array(
            'dict' => $entity->getDict()));

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArretePromulgue:contenu.html.twig', array(
            'entity'      => $entity,
            'dict' => $entity->getDict(),
            'renderedTemplate' => $renderedTemplate
        ));
    }
    /**
     * Finds and displays a ArretePromulgue entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArretePromulgue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArretePromulgue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        return $this->render('MairieVoreppeDemandeTravauxBundle:ArretePromulgue:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'dict' => $entity->getDict()
        ));
    }

    /**
     * Displays a form to edit an existing ArretePromulgue entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArretePromulgue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArretePromulgue entity.');
        }

        $editForm = $this->createEditForm($entity, $entity->getDict());
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArretePromulgue:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ArretePromulgue entity.
    *
    * @param ArretePromulgue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ArretePromulgue $entity, $dict)
    {
        $form = $this->createForm(new ArretePromulgueType($dict), $entity, array(
            'action' => $this->generateUrl('arretepromulgue_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing ArretePromulgue entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArretePromulgue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArretePromulgue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $entity->getDict());
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('arretepromulgue_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArretePromulgue:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ArretePromulgue entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArretePromulgue')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ArretePromulgue entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('arretepromulgue'));
    }

    /**
     * Creates a form to delete a ArretePromulgue entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('arretepromulgue_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
   
    
    public function genererArreteAction(Request $request, $id)
    {
         $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArretePromulgue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArretePromulgue entity.');
        }
        
        $entityDict = $entity->getDict();
        $entityArreteModel = $entity->getArreteModel();
        

        $html = $this->renderView('MairieVoreppeDemandeTravauxBundle:ArretePromulgue:generer_arrete.html.twig', array(
         'arreteModele'  => $entityArreteModel,
         'dict' => $entityDict
        ));


         return new Response(
             $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
             200,
             array(
                 'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );       
    }
}
