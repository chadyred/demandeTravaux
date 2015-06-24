<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;


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
            ->add('telephoneRepresentant', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL))
            ->add('planJoint')
            ->add('emplacementsReseauOuvrage', 'collection', array(
                'type' => new EmplacementReseauOuvrageType(),
                'allow_add' => true,
                'allow_delete' => false,
                'label' => false
            ))
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
            ->add('miseHorsTension', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\MiseHorsTension",
                "property" => 'libelle',
                'multiple' => false,
                'expanded' => true
            ))
            ->add('dispositifsSecurite', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecurite",
                "property" => 'description',
                'multiple' => true,
                'expanded' => true,
                'label' => false
            ))
            ->add('telServiceDegradation', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL))
            ->add('serviceDepartementIncendieSecours')
            ->add('telServiceDepartementIncendieSecours', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL))
            ->add('responsableDossier')
            ->add('telResponsableDossier', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL))
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
