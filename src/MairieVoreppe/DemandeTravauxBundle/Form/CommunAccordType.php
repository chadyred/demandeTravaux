<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommunAccordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateRetenue', 'collot_datetime', array("label" => false, "attr" => array(
                'data-provide'=>"datepicker", 
                "data-date-format"=>"dd/mm/yyyy - HH:ii", "data-date-language" => "fr"),
              'pickerOptions' => array(
                  'format' => 'dd MM yyyy - HH:ii p',
                  'language' => 'fr',
                  'minView' => 'hour',
                  'minuteStep' => 5,
              )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\CommunAccord'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_communaccord';
    }
}
