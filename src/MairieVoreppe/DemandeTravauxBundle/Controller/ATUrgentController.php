<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MairieVoreppe\DemandeTravauxBundle\Entity\ATUrgent;
use MairieVoreppe\DemandeTravauxBundle\Form\ATUrgentType;

/**
 * ATUrgent controller.
 *
 */
class ATUrgentController extends Controller
{

    /**
     * Lists all ATUrgent entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ATUrgent')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:ATUrgent:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ATUrgent entity.
     *
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();

        $entity = new ATUrgent();

        $form = $this->createCreateForm($entity, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            foreach($entity->getAdresses() as $uneAdresse)
            {
                //Afin d'insiter l'utilisateur à saisir une adresse, j'ajoute un prototype même lors de l'update. Or, cela va créé une entité
                //null. Elle sera prise en compte.
                 if($uneAdresse != null) {
                    $uneAdresse->setTravaux($entity);
                    $em->persist($uneAdresse);
                }
            }
            
            
            $entity->setUser($user);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aturgent_show', array('id' => $entity->getId())));
        }

        return $this->render("MairieVoreppeDemandeTravauxBundle:ATUrgent:new.html.twig", array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ATUrgent entity.
     *
     * @param ATUrgent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ATUrgent $entity, $user)
    {
        $form = $this->createForm(new ATUrgentType($user), $entity, array(
            'action' => $this->generateUrl('aturgent_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer !'));

        return $form;
    }

    /**
     * Displays a form to create a new ATUrgent entity.
     *
     */
    public function newAction()
    {
        $user = $this->getUser();

        $entity = new ATUrgent();

        $form   = $this->createCreateForm($entity, $user);

        return $this->render('MairieVoreppeDemandeTravauxBundle:ATUrgent:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ATUrgent entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ATUrgent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ATUrgent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:ATUrgent:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ATUrgent entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ATUrgent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ATUrgent entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:ATUrgent:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ATUrgent entity.
    *
    * @param ATUrgent $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ATUrgent $entity)
    {
        $form = $this->createForm(new ATUrgentType(), $entity, array(
            'action' => $this->generateUrl('aturgent_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing ATUrgent entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ATUrgent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ATUrgent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if(count($entity->getAdresses()) > 0)
            {
                foreach($entity->getAdresses() as $uneAdresse)
                {
                    //Afin d'insiter l'utilisateur à saisir une adresse, j'ajoute un prototype même lors de l'update. Or, cela va créé une entité
                    //null. Elle sera prise en compte.
                     if($uneAdresse != null) {
                        $uneAdresse->setTravaux($entity);
                        $em->persist($uneAdresse);
                    }
                }
            }

            //La suppression d'une adresse s'effectuera ici, après la persistence des éventuelle nouvelle créée
            if(count($entity->getAdresses()) > 0)
            {
                //On parcours les période sur le fomulaulaire.
                foreach($editForm->get('adresses') as $adress)
                {
                    
                    //Si un des bouttons de l'une d'entre elle est cliqué, cela déclanchera le submit du formulaire, c'est pourquoi on atterira dans cette action
                    //du controller. On va regarder si un des boutton a été cliquer. Pour cela on va vérifier tous ceux présent sur le formulaire en cours.
                    //Le boutton peut ne pas exister si l'adresse est la première adresse. Cependant, 'isset' ne peut vérifier que les variable et non ce que retourne les fonctions
                    //on ne peut pas vérifier alors 'if(isset($adress->get('delete')) == TRUE' (même sans le TRUE)
                    if(isset($adress["delete"]) && $adress->get('delete')->isClicked())
                    {
                        //Le DRY ne marche pas pour la OneToMany.
                        //On récupère les données qui sont derrière l'instance de la structure parmis les adressses, et plus particulièrement
                        //l'identifiant de la période du bouton
                        $idAdresseBoutonDeleteClique = $adress->getData()->getId();
                        
                        //On récupère l'entité lié à cette id
                        $adress = $em->getRepository('MairieVoreppeDemandeTravauxBundle:Adresse')->find($idAdresseBoutonDeleteClique);   
                        
                        //On la supprime.
                        $em->remove($adress);
                    }
                }          
            }
            
              //La suppression d'un contact urgent s'effectuera ici, après la persistence des éventuelle nouvelle créée
            if(count($entity->getContactsUrgent()) > 0)
            {
                //On parcours les période sur le fomulaulaire.
                foreach($editForm->get('contactsUrgent') as $cu)
                {
                    
                    //Si un des bouttons de l'une d'entre elle est cliqué, cela déclanchera le submit du formulaire, c'est pourquoi on atterira dans cette action
                    //du controller. On va regarder si un des boutton a été cliquer. Pour cela on va vérifier tous ceux présent sur le formulaire en cours.
                    //Le boutton peut ne pas exister si l'adresse est la première adresse. Cependant, 'isset' ne peut vérifier que les variable et non ce que retourne les fonctions
                    //on ne peut pas vérifier alors 'if(isset($adress->get('delete')) == TRUE' (même sans le TRUE)
                    if(isset($cu["delete"]) && $cu->get('delete')->isClicked())
                    {
                        //On récupère les données qui sont derrière l'instance de la structure parmis les adressses
                        $entity->removeContactsUrgent($cu->getData());
                    }
                }          
            }
            
            
            
            $em->flush();

            return $this->redirect($this->generateUrl('aturgent_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:ATUrgent:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ATUrgent entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ATUrgent')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ATUrgent entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aturgent'));
    }

    /**
     * Creates a form to delete a ATUrgent entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aturgent_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
