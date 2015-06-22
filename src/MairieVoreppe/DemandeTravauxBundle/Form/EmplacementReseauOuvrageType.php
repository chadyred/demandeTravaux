<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmplacementReseauOuvrageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Ajout du calendrier français de bootstrap (Rappel : le type="date" n'est pas compatible sur Firefox, Explorer, Safari etc etc ...)
        $builder
            ->add('reference', 'text', array("label" => false, "attr" => array("field" => "reference")))
            ->add('echelle','text' , array("label" => false, "attr" => array("field" => "echelle")))
            ->add('dateEdition', 'collot_datetime', array("label" => false, "attr" => array("field" => "dateEdition", 
                'data-provide'=>"datepicker", 
                "data-date-format"=>"dd/mm/yyyy", "data-date-language" => "fr"),
              'pickerOptions' => array(
                  'format' => 'dd/mm/yyyy',
                  'language' => 'fr'
              )))
            ->add('sensible',"checkbox", array("label" => false, "attr" => array("field" => "sensible")))
            ->add('profondeurReglMini', "number", array("label" => false, "attr" => array("field" => "profondeurReglMini")))
            ->add('materiauxReseau', "text", array("label" => false, "attr" => array("field" => "materiauxReseau")))
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\EmplacementReseauOuvrage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_emplacementreseauouvrage';
    }
}
