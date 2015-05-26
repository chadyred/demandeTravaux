<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArreteModelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            //Dans la config au sein du type utilisé par un champs, on retrouve config array('skin' => 'office2013', config.colorUi...parser en JS, devenant config.skin
            //cette configuration peut être facilement centralisée au sein du fichier de configuration
            ->add('contenu', 'ckeditor', array('required' => true, 
                    'config' => array(
                        'jquery' => true,
                        // Max width is A4 size
                        'width' => '190mm',
                        'height' => '100mm',
                        // Max width is A4 size
                        'minWidth' => '190mm',
                        'minHeight' => '100mm',

                        // Max width is A4 size
                        'maxWidth' => '190mm',
                        'maxHeight' => '100mm',


                        // Needs to be bound at A4 size
                        'removePlugins' => 'resize',
                        'resize_enabled' => false,

                        // Toolbar hiding bugs size
                        'toolbarCanCollapse' => false,

                        // Make sure everything is set into page
                        'fullPage' => true,
        
                        'toolbar' => array(
                            array(
                                'name'  => 'basicstyles',
                                'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Justify' , '-', 'RemoveFormat'),
                            ),
                            array(
                                'name' => 'paragraph',
                                'items' => array('NumberedList','BulletedList', 'lineheight', '-','Outdent','Indent','-','Blockquote','CreateDiv',
	'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'),
                            ),
                            array(
                                'name' => 'Agrandir',
                                'items' => array('Maximize'),
                            ),   
                            array(
                                'name' => 'clipboard', 
                                'items' => array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo')
                            ),      
                            '/',
                            array(
                                'name'  => 'document',
                                'items' => array('Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates'),
                            ),  '/',
                            array(
                                'name'  => 'font',
                                'items' => array('Styles','Font','FontSize'),
                            ),                    
                        ),
                        //ne fonctionne pas
                        'bodyId' => 'ck_editor_content',
                        'uiColor' => '#ffffff',  
                        //Pas d'espace dans le chemin, même après la virgule ! 
                        'extraPlugins' => 'wordcount,lineheight',
                        //Pas d'espace dans le chemin, même après la virgule !
                        'skin' => 'office2013,/bundles/mairievoreppedemandetravaux/skins_ckeditor/office2013/',
                        //J'ajoute mes styles ici
                        'stylesSet' => 'my_styles',
                        'contentsCss' => "/bundles/mairievoreppedemandetravaux/css/ckeditor_content.css"
                        
                    ),
                    //Les styles sont présent dans la liste des styles, il permette d'insérer divers chose sur les éléments indiqués.
                    'styles' => array(
                        'my_styles' => array(
                            array('name' => 'Blue Title', 'element' => 'body', 'styles' => array('color' => 'Blue')),                        
                            array('name' => 'CSS Style', 'element' => 'span', 'attributes' => array('class' => 'my_style')),
                     )),
                    'plugins' => array(
                        'wordcount' => array(
                            'path'     => '/bundles/mairievoreppedemandetravaux/plugins_ckeditor/wordcount/',
                            'filename' => 'plugin.js',
                        ),  
                        'lineheight' => array(
                            'path'     => '/bundles/mairievoreppedemandetravaux/plugins_ckeditor/lineheight/',
                            'filename' => 'plugin.js',
                        ),  
                    ),
                    
                    
                ))
            ->add('dict', 'entity', array('class' => 'MairieVoreppeDemandeTravauxBundle:DemandeIntentionCT',
                'property' => "numeroTeleservice",
                'mapped' => false,
                'attr' => array('class' => 'hidden'),
                'label' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\ArreteModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_arretemodel';
    }
}
