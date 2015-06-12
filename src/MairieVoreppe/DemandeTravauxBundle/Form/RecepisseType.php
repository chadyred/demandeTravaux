<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecepisseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('reponse', 'infinite_form_polycollection', array(
                'types' => array(
                    'mairievoreppe_demandetravauxbundle_nonconcerne' => "Concerné", // The first defined Type becomes the default
                    'mairievoreppe_demandetravauxbundle_concerne' => "Non concerné",
                    'mairievoreppe_demandetravauxbundle_demandeimprecise' => "Demande imprécise"
                    ),
                    'allow_add' => false,
                    'allow_delete' => false
               ))
            ->add('rendezVous')
            ->add('miseHorsTension')
            ->add('dispositifsSecurite')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Recepisse'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_recepisse';
    }
}
