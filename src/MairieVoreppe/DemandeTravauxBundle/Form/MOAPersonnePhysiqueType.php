<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MOAPersonnePhysiqueType extends DeclarantType
{
    
    protected $class = 'MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonnePhysique';
        
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('civil', new CivilType())
        ;
    }
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_moapersonnephysique';
    }
}
