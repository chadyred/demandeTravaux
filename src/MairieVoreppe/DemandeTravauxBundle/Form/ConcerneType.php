<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConcerneType extends ReponseType
{
    protected $dataClass = 'MairieVoreppe\\DemandeTravauxBundle\\Entity\\Concerne';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('categorieReseauOuvrage', 'entity', array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\CategorieReseauOuvrage",
                'multiple' => true,
                'expanded' => true
        ))
        ;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_concerne';
    }
}
