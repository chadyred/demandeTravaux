<?php

namespace MairieVoreppe\DemandeTravauxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use MairieVoreppe\DemandeTravauxBundle\Entity\ArreteModel;
use MairieVoreppe\DemandeTravauxBundle\Entity\DtDict;
use MairieVoreppe\DemandeTravauxBundle\Form\ArreteModelType;
use MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux;
use MairieVoreppe\DemandeTravauxBundle\Model\MaitreOuvrage;
use MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent;
use MairieVoreppe\DemandeTravauxBundle\Model\Travaux;
use MairieVoreppe\DemandeTravauxBundle\Entity\CanalReception;
use MairieVoreppe\UserBundle\Entity\User;
use MairieVoreppe\DemandeTravauxBundle\Entity\Civilite;
use MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique;
use MairieVoreppe\DemandeTravauxBundle\Entity\Adresse;
use MairieVoreppe\DemandeTravauxBundle\Model\Personne;
use MairieVoreppe\UserBundle\Entity\Service;
use MairieVoreppe\DemandeTravauxBundle\Entity\Mairie;
use MairieVoreppe\DemandeTravauxBundle\Entity\Logo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use MairieVoreppe\DemandeTravauxBundle\Model\MaitreOeuvre;
use MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonneMorale;
use MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonnePhysique;

/**
 * ArreteModel controller.
 *
 */
class ArreteModelController extends Controller
{

    private $reflectionClass = array();
    /**
     * Lists all ArreteModel entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArreteModel')->findAll();

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArreteModel:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ArreteModel entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ArreteModel();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('arretemodel_show', array('id' => $entity->getId())));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArreteModel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ArreteModel entity.
     *
     * @param ArreteModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ArreteModel $entity)
    {
        $form = $this->createForm(new ArreteModelType(), $entity, array(
            'action' => $this->generateUrl('arretemodel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ArreteModel entity.
     *
     */
    public function newAction()
    {
        $entity = new ArreteModel();
        $form   = $this->createCreateForm($entity);
       
        
        $classeArreteModel = new \ReflectionClass('MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT');
        
        $attributes = $this->reflection($classeArreteModel);        

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArreteModel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Finds and displays a ArreteModel entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArreteModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArreteModel entity.');
        }
        
        
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArreteModel:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ArreteModel entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        //Ces instance sont nécessaire pour la réflexivité sans quoi, 
        $pm = new \MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonneMorale();
        $pm = new \MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonnePhysique();
        $pm = new \MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMorale();
        $pm = new \MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonnePhysique();
        $pm = new \MairieVoreppe\DemandeTravauxBundle\Entity\Maire();
        
        $classeArreteModel = new \ReflectionClass('MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT');
        
        $attributes = $this->reflection($classeArreteModel);        
       

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArreteModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArreteModel entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArreteModel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'reflectionClass' => $this->reflectionClass,
            'attributes' => $attributes
        ));
    }

    /**
    * Creates a form to edit a ArreteModel entity.
    *
    * @param ArreteModel $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ArreteModel $entity)
    {
        $form = $this->createForm(new ArreteModelType(), $entity, array(
            'action' => $this->generateUrl('arretemodel_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ArreteModel entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArreteModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ArreteModel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('arretemodel_edit', array('id' => $id)));
        }

        return $this->render('MairieVoreppeDemandeTravauxBundle:ArreteModel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ArreteModel entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArreteModel')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ArreteModel entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('arretemodel'));
    }

    /**
     * Creates a form to delete a ArreteModel entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('arretemodel_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Fonction qui parcours de manière récursive les metadatas d'une classe. On récupère alors 
     * les classes lié à ma dict
     * 
     * @param \ReflectionClass $classe
     * @return type
     */
    private function reflection(\ReflectionClass $classe)
    {        
        //var_dump(get_declared_classes());
        $this->reflectionClass[$classe->name] = $classe;
        $attribut_method[$classe->name][] = array();

        //var_dump($classe);
         foreach ($classe->getProperties() as $attribut) {
             //ReflectionException
            //var_dump($attribut);
            $trouveSet = false;
            $trouveAdd = false;
            foreach($classe->getMethods() as $method){
                if($method->getName() === 'set' . ucfirst($attribut->name))
                    $trouveSet = true;
                elseif($method->getName() === 'add' . ucfirst($attribut->name))
                    $trouveAdd = true;
            }


            if($trouveSet)
            {
                $methodAttribut = $classe->getMethod('set' . ucfirst($attribut->name));
                //var_dump("trouvé set ");
                //var_dump('set' . ucfirst($attribut->name));
                //echo $methodAttribut->name;
            }
            else
            {
                if($trouveAdd)
                {
                    $methodAttribut = $classe->getMethod('add' . ucfirst($attribut->name));
                    //var_dump("trouvé add");
                }
            }
            
            if(isset($methodAttribut) && !empty($methodAttribut))
            {                
                //var_dump("Parameter => ");
                $parameter = $methodAttribut->getParameters()[0];
                $classAssociation = $parameter->getClass();
                if($classAssociation != NULL)
                {                
                    //On récupère la classe associé présente dans el type du paramêtre de la fonction
                    $nameClassAssociation = $parameter->getClass()->name;
                    
                    //On exclus les type de Symfony
                    $classExlus = array('DateTime', 'Symfony\Component\HttpFoundation\File\UploadedFile');
                    
                    /**
                    * Permet de vérifier si l'association n'est pas déjà parcourru: 
                    * - il n'est pas dans le tableau de celles déjà parcourrus
                    * - que l'attribut de la méthode possède bien une classe associée
                    * - qu'il n'est pas dans les classes de Symfony
                    */
                    if(!array_key_exists($nameClassAssociation, $this->reflectionClass) && $nameClassAssociation && !in_array($nameClassAssociation, $classExlus))
                    {
                       
                            $this->reflection($classAssociation);

                    }
                    else
                    {
                       //echo $classAssociation->getName() . " existe dans le tableau.";
                    }
                }
            }
        }  
    }
    
    private function getSubclassesOf($parent) {
        $result = array();
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, $parent)){
                $result[] = $class;
//            var_dump($class);
            }
        }
        return $result;
    }
    
    public function downloadAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('MairieVoreppeDemandeTravauxBundle:ArreteModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find modelArrete entity.');
        }
        //var_dump($entityArreteModel);

        $html = $this->renderView('MairieVoreppeDemandeTravauxBundle:ArreteModel:generer_arrete_model.html.twig', array(
         'arreteModele'  => $entity
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
