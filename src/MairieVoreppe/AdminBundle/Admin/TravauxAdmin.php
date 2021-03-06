<?php
 // Kark/AdminBundle/Admin/ArticleAdmin
namespace MairieVoreppe\AdminBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;
use libphonenumber\PhoneNumberFormat;
 
class TravauxAdmin extends AbstractAdmin
{
	 // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'id'
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
                
                 ->add('numeroTeleservice')
                 ->add('serviceExploitant', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant",
                'multiple' => false,
                'expanded' => false,
                'empty_data' => false,
                'placeholder' => '-'))
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
            ->add('numeroTeleservice')
        ;
    }
 
 	/**
 	* Fonction qui redéfini celle de la classe mère Admin. Cette fonction va nous permettre de préciser les
 	* champs qui seront affiché dans notre tableau lorsque l'on listera nos entités
 	*/
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('route' => array('name' => 'show')))
            ->add('numeroTeleservice')
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
            ->add('numeroTeleservice')
        ;
    }

}