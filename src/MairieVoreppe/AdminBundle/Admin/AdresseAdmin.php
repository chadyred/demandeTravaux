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
 
class AdresseAdmin extends AbstractAdmin
{
	 // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'adresse'
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
                
                 ->add('autocomplete', 'text', array('mapped' => false, 'required' => false,
                    "attr" => array('autocomplete' => 'autocomplete',
                                    "onFocus" => "geolocate()",
                                    "placeholder" => "Saisissez une adresse")))
                    ->add('numeroRue', 'text', array('attr' => array('street_number' => 'street_number')))
                    ->add('adresse', 'text', array('attr' => array('route' => 'route')))
                    ->add('complementAdresse', 'text',  array('required' => false))
                    ->add('lieuDit', 'text',  array('required' => false, 'attr' => array('lieuDit' => 'lieuDit')))       
                    ->add('ville', 'text', array('attr' => array('locality' => 'locality')))
                    ->add('cp', 'text', array('attr' => array('postal_code' => 'postal_code')))
                    ->add('pays', 'text', array('attr' => array('country' => 'country')))
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
            ->add('adresse')
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
            ->add('adresse')
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
            ->add('adresse')
        ;
    }

}