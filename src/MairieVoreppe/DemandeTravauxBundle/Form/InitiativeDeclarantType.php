<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InitiativeDeclarantType extends RendezVousType
{
    protected $dataClass = 'MairieVoreppe\\DemandeTravauxBundle\\Entity\\InitiativeDeclarant';
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('dateRetenue', 'date', array("label" => false))
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_initiativedeclarant';
    }
}
