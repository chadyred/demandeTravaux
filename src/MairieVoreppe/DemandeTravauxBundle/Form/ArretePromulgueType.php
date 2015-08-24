<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArretePromulgueType extends AbstractType
{
    private $entityDict;
    
    public function __construct($entityDict) {
       $this->entityDict = $entityDict;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('arreteModel', 'entity', array('class' => 'MairieVoreppeDemandeTravauxBundle:ArreteModel',
            'property' => 'titre',
            "required" => true))
            ->add('dict', 'entity', array('attr' => array('class' => 'hidden'),
                'label' => false,
                'class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT',
                'property' => 'id',
                'data' => $this->entityDict->getId(),
                "required" => true))
            ->add('submit', 'submit', array('label' => 'Generer'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\ArretePromulgue'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_arretepromulgue';
    }
}
