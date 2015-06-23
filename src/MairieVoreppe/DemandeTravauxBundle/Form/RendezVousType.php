<?php
// src/Infinite/InvoiceBundle/Form/RendezVousType.php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RendezVousType extends BaseType
{
    protected $dataClass = 'MairieVoreppe\\DemandeTravauxBundle\\Model\\RendezVous';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('_type', 'hidden', array(
            'data'   => $this->getName(),
            'mapped' => false
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'  => $this->dataClass,
            'model_class' => $this->dataClass,
        ));
    }

    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_rendezvous';
    }
}