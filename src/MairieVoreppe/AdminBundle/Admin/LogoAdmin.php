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
 
class LogoAdmin extends AbstractAdmin
{
	 // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'alt'
    );

    
    // L'ensemble des champs qui seront montrer lors de la création ou de la modification d'une entité
    protected function configureFormFields(FormMapper $formMapper)
    {
        // get the current Image instance
        $logo = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
        if ($logo && ($webPath = $logo->getWebPath())) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="admin-preview" />';
        }

        $formMapper
            ->with('General')
                ->add('file', 'file', $fileFieldOptions)                
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
            ->add('alt')
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
            ->add('alt')
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
            ->add('alt')
        ;
    }

}