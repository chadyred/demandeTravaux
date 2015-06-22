<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecepisseDICTType extends ReponseType
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
                    'mairievoreppe_demandetravauxbundle_nonconcerne', // The first defined Type becomes the default
                    'mairievoreppe_demandetravauxbundle_concerne',
                    'mairievoreppe_demandetravauxbundle_demandeimprecise'
                    ),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => false
               ))
            ->add('chantierSensible')             
            ->add('extensionPrevue')
            ->add('modificationEnCours')
            ->add('nomRepresentant')
            ->add('telephoneRepresentant')
            ->add('planJoint')
            ->add('priseRendezVous')
            ->add('rendezVous','infinite_form_polycollection', array(
                'types' => array(
                    'mairievoreppe_demandetravauxbundle_communaccord', // The first defined Type becomes the default
                    'mairievoreppe_demandetravauxbundle_initiativedeclarant'
                    ),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => false
               ))
            ->add('prendreEnCompteServitude')
            ->add('branchementRattache')
            ->add('recommandationSecurite')
            ->add('rubriqueGuideTechSecurite')
            ->add('mesureSecurite')
            ->add('telServiceDegradation')
            ->add('serviceDepartementIncendieSecours')
            ->add('telServiceDepartementIncendieSecours')
            ->add('emplacementsReseauOuvrage', 'collection', array(
                'type' => new EmplacementReseauOuvrageType(),
                'allow_add' => true,
                'allow_delete' => false,
                'label' => false
            ))
            ->add('responsableDossier')
            ->add('telResponsableDossier')
            ->add('miseHorsTension', new MiseHorsTensionType())
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
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICT'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_recepissedict';
    }
}
