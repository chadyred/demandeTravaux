<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecepisseDTType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('reponse', 'infinite_form_polycollection', array(
                'types' => array(
                    'mairievoreppe_demandetravauxbundle_demandeimprecise',
                    'mairievoreppe_demandetravauxbundle_nonconcerne', // The first defined Type becomes the default
                    'mairievoreppe_demandetravauxbundle_concerne'
                    ))
                )
            ->add('prevoirInvestiguation')
            ->add('dateCreation')
            ->add('extensionPrevue')
            ->add('modificationEnCours')
            ->add('nomRepresentant')
            ->add('telephoneRepresentant')
            ->add('planJoint')
            ->add('prendreEnCompteServitude')
            ->add('branchementRattache')
            ->add('recommandationSecurite')
            ->add('rubriqueGuideTechSecurite')
            ->add('mesureSecurite')
            ->add('telServiceDegradation')
            ->add('serviceDepartementIncendieSecours')
            ->add('telServiceDepartementIncendieSecours')
            ->add('responsableDossier')
            ->add('telResponsableDossier')                
            ->add('rendezVous')
            ->add('miseHorsTension')
            ->add('_type', 'hidden', array(
                'data'   => $this->getName(),
                'mapped' => false
             ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT',
            'model_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_recepissedt';
    }
}
