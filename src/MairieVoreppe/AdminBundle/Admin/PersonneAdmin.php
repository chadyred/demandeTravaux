<?php
 // Kark/AdminBundle/Admin/ArticleAdmin
namespace MairieVoreppe\AdminBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use MairieVoreppe\DemandeTravauxBundle\Form\LogoType;
use MairieVoreppe\DemandeTravauxBundle\Form\AdresseType;

use Knp\Menu\ItemInterface as MenuItemInterface;
use libphonenumber\PhoneNumberFormat;
 
class PersonneAdmin extends AbstractAdmin
{
	 // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'raisonSociale'
    );

    
    // L'ensemble des champs qui seront montrer lors de la création ou de la modification d'une entité
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                /*->add('user', 'sonata_type_model',  array(
                    'btn_add'       => false,      //Ce bouton nous permet d'ajouter une entité dans la BDD
                    'btn_list'      => false,     //which will be translated
                    'btn_delete'    => false,             //or hide the button.
                    'btn_catalogue' => 'SonataNewsBundle', //Custom translation domain for buttons
                ), array(
                    'placeholder' => 'No author selected',
                    'attr' => array('hidden' => true)
                ))   */                
                
                ->add('telFixe', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, 'required' => false))
                ->add('adresse', 'sonata_type_admin', array('delete' => false), array('required' => true, 'edit' => 'inline'))
            ->end()
        ;
    }

    /**
    *
    * Fonction qui va permettre d'afficher les différents filtres de recherche dans notre tableau 
    * de notre interface.
    *
    */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('raisonSociale')
        ;
    }
 
 	/**
 	* Fonction qui redéfini celle de la classe mère Admin. Cette fonction va nous permettre de préciser les
 	* champs qui seront affiché dans notre tableau lorsque l'on listera nos entités
 	*/
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('raisonSociale')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array()
                )
            ))
        ;
    }

    /**
    * Fonction qui redéfinie la fonction de la classe mère qui permet d'indiquer les champs qui seront affichés
    * lorsque l'on consultera un exploitantService
    */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('raisonSociale')
        ;
    }

    public function preUpdate($object)
    {   
        $this->gestionPersistanceAdresse($object);
    }

    public function prePersist($object)
    {
        $this->gestionPersistanceAdresse($object);
    }

    protected function gestionPersistanceAdresse($object)
    {
        // $adresse = $this->getForm()->get('adresse')->getData();
        // $adresse->setPersonne($object);
         // On parcours chacun des champs
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription)
        {

        //     /**
        //     * Gestion de l'administration de l'image
        //     */
        //     if($fieldDescription->getType() === 'sonata_type_admin' &&
        //         ($associationMapping = $fieldDescription->getAssociationMapping()) &&
        //         ($associationMapping['targetEntity'] === 'MairieVoreppe\DemandeTravauxBundle\Entity\Adresse' ))
        //     {
        //         $getter = 'get' . $fieldName;
        //         $setter = 'set' . $fieldName;

        //         /** @var Image $image */
        //         $adresse = $object->$getter();
        //         if($adresse)
        //         {
        //             $object->setAdresse($adresse);
        //             $em->persist($adresse);

        //         }

        //     }
              /**
            * Gestion de l'administration de l'image
            */
            if(($associationMapping = $fieldDescription->getAssociationMapping()) &&
                ($associationMapping['targetEntity'] === 'MairieVoreppe\DemandeTravauxBundle\Entity\Logo' ))
            {
                $getter = 'get' . $fieldName;
                $setter = 'set' . $fieldName;

                /** @var Image $image */
                $logo = $object->$getter();
                if($logo)
                {
                    // update the Image to trigger file management
                    $logo->preUpload();

                }

            }
        }
    }

}