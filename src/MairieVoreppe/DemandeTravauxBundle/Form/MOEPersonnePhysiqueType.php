<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MOEPersonnePhysiqueType extends DeclarantType
{
    
    protected $class = 'MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonnePhysique';
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('civil', new CivilType($this->villeCp))
        ;
    }
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_moepersonnephysique';
    }
}
