<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MairieVoreppe\DemandeTravauxBundle\Entity\Mairie;

class PeriodeType extends AbstractType
{
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maire',  new MaireType())
            ->add('dateDebut', 'collot_datetime', array( 
              "attr" => array('data-provide'=>"datepicker", 
                "data-date-format"=>"dd/mm/yyyy", "data-date-language" => "fr"),
              'pickerOptions' => array(
                  'format' => 'dd/mm/yyyy',
                  'language' => 'fr'
              )))
            ->add('dateFin', 'collot_datetime', array( 
              "attr" => array('data-provide'=>"datepicker", 
                "data-date-format"=>"dd/mm/yyyy", "data-date-language" => "fr"),
              'pickerOptions' => array(
                  'format' => 'dd/mm/yyyy',
                  'language' => 'fr'
              )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Periode'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_maire';
    }
}
