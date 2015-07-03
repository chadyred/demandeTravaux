<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICT;


class RecepisseDICTType extends ReponseType
{
    public $entity;

    public function __construct($recepisseDict = null)
    {
        $this->entity=  $recepisseDict;
    }

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
                    'mairievoreppe_demandetravauxbundle_demandeimprecise',
                    'mairievoreppe_demandetravauxbundle_concerne'
                    ),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'mapped' => false
               ))
            //->add('reponse', null, array(
             //   'choices' => array( new NonConcerneType() => 'NC', new DemandeImpreciseType() => 'DI', new  ConcerneType() => "C")
              //  ))
            ->add('chantierSensible')             
            ->add('extensionPrevue', 'text', array('label' => "Extension dans un délai inférieur à 3 mois"))
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
                    'by_reference' => false,
                    'mapped' => false
               ))
            ->add('prendreEnCompteServitude')
            ->add('branchementRattache')
            ->add('recommandationSecurite')
            ->add('rubriqueGuideTechSecurite')
            ->add('mesureSecurite')
            ->add('miseHorsTension', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\MiseHorsTension",
                "property" => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('dispositifSecurite', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecurite",
                "property" => 'description'
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
