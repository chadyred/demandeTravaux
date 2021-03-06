<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommunAccordType extends RendezVousType
{
    protected $dataClass = 'MairieVoreppe\\DemandeTravauxBundle\\Entity\\CommunAccord';
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('dateRetenue', 'date', array('label' => false,'format' => 'dd-MM-yyyy',
             'attr' => array('class' => 'datetimepicker'),
             "required" => true
                ))
        ;
    }
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_communaccord';
    }
}
