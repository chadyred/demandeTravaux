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
            ->add('reponse')
            ->add('rendezVous')
            ->add('miseHorsTension')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT'
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
