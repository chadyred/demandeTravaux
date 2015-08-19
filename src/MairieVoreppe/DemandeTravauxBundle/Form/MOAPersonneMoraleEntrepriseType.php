<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MOAPersonneMoraleEntrepriseType extends DeclarantType
{
    protected $class = 'MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonneMorale';
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('personneMorale', new EntrepriseType())
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_moapersonnemorale_entreprise';
    }
}
