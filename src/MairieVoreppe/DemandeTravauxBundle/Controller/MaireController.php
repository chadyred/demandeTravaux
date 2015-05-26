<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\Maire;
use MairieVoreppe\DemandeTravauxBundle\Form\MaireType;
use MairieVoreppe\DemandeTravauxBundle\Form\MaireEditType;
use MairieVoreppe\DemandeTravauxBundle\Entity\Mairie;

/**
 * Maire controller.
 *
 */
class MaireController extends Controller
{

    /**
     * Lists all Maire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Maire')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:Maire:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    /**
     * Lists Maire within a Mairie.
     *
     */
    public function indexByMairieAction(Mairie $mairie)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Maire')->myFindByMairie($mairie->getId());

        return $this->render('MairieVoreppeDemandeTravauxBundle:Maire:index_by_mairie.html.twig', array(
            'entities' => $entities,
            'mairie' => $mairie
        ));
    }
    
    
    /**
     * Creates a new Maire entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Maire();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();            
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('maire_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:Maire:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Maire entity.
     *
     * @param Maire $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Maire $entity)
    {
        $form = $this->createForm(new MaireType(), $entity, array(
            'action' => $this->generateUrl('maire_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Maire entity.
     *
     */
    public function newAction()
    {
        $entity = new Maire();
        $form   = $this->createCreateForm($entity);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Maire:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Finds and displays a Maire entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Maire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Maire entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Maire:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Maire entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Maire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Maire entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:Maire:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
    * Creates a form to edit a Maire entity.
    *
    * @param Maire $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Maire $entity)
    {
        
        
        $form = $this->createForm(new MaireEditType($entity), $entity, array(
            'action' => $this->generateUrl('maire_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Maire entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Maire')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Maire entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            //La suppression d'une période s'effectuerae ici
            if(count($entity->getPeriodes()) > 0)
            {
                //On parcours les période sur le fomulaulaire.
                foreach($editForm->get('periodes') as $periode)
                {
                    //Si un des bouttons de l'une d'entre elle est cliqué, cela déclanchera le submit du formulaire, c'est pourquoi on atterira dans cette action
                    //du controller. On va regarder si un des boutton a été cliquer. Pour cela on va vérifier tous ceux présent sur le formulaire en cours.
                    if($periode->get('delete')->isClicked())
                    {
                        //On récupère les données qui sont derrière l'instance de la structure parmis les périodes, et plus particulièrement
                        //l'identifiant de la période du bouton
                        $idPeriodeBoutonDeleteClique = $periode->getData()->getId();
                        
                        //On récupère l'entité lié à cette id
                        $periode = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Periode')->find($idPeriodeBoutonDeleteClique);   
                        
                        //On la supprime.
                        $em->remove($periode);
                    }
                }          
            }
            $em->flush();

            return $this->redirect($this->generateUrl('maire_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:Maire:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Maire entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $referer = $this->getRequest()->headers->get('referer');
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Maire')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Maire entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($referer);
    }

    /**
     * Creates a form to delete a Maire entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('maire_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
