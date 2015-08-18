<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MOEPersonneMoraleType extends DeclarantType
{
    protected $class = 'MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMorale';
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('entreprise', new EntrepriseType())
            ->add('prestataireDICT', 'checkbox', array('required' => "false"))
        ;
    }
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_moepersonnemorale';
    }
}
