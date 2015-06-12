<?php
// src/Infinite/InvoiceBundle/Form/Type/ReponseType.php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReponseType extends BaseType
{
    protected $dataClass = 'MairieVoreppe\\DemandeTravauxBundle\\Model\\Reponse';

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
        return 'mairievoreppe_demandetravauxbundle_reponse';
    }
}