<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RecepisseType extends AbstractType
{
    protected $dataClass = 'MairieVoreppe\\DemandeTravauxBundle\\Model\\Recepisse';

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
            ->add('chantierSensible', "checkbox",array('required' => false))             
            ->add('extensionPrevue', 'text', array('label' => "Extension dans un délai inférieur à 3 mois", 'required' => false))
            ->add('modificationEnCours', "text",array('required' => false))
            ->add('nomRepresentant', "text",array('required' => false))
            ->add('telephoneRepresentant', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, 'required' => false))
            ->add('planJoint', "checkbox", array('required' => false))
            ->add('emplacementsReseauOuvrage', 'collection', array(
                'type' => new EmplacementReseauOuvrageType(),
                'allow_add' => true,
                'allow_delete' => false,
                'label' => false
            )) 
            ->add('priseRendezVous', "checkbox", array('required' => false))
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
            ->add('prendreEnCompteServitude', "checkbox", array('required' => false))
            ->add('branchementRattache', "checkbox", array('required' => false))
            ->add('recommandationSecurite', "text", array('required' => false))
            ->add('rubriqueGuideTechSecurite',"text", array('required' => false))
            ->add('mesureSecurite', "text", array('required' => false))
            ->add('miseHorsTension', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\MiseHorsTension",
                "property" => 'libelle',
                'multiple' => false,
                'expanded' => false
            ))
            ->add('dispositifSecurite', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecurite",
                "property" => 'description',
                'required' => false
            ))
            ->add('telServiceDegradation', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, 'required' => false))
            ->add('serviceDepartementIncendieSecours', "text",array('required' => false))
            ->add('telServiceDepartementIncendieSecours', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, 'required' => false))
            ->add('responsableDossier', "text", array('required' => false))
            ->add('telResponsableDossier', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, 'required' => false))
        ;

        /**
         * Ceci va permettre de mettre un lien de suppression uniquement sur les autres car la première adresse est obligatoire
         */
         $builder->get('rendezVous')->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $rendezVous = $event->getData();
                $form = $event->getForm();
                
                for($i = 0;count($rendezVous) > $i;$i++)
                {
                     $form->get($i)
                          ->add('delete', 'submit');
                }
       
        });

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'  => $this->dataClass,
            'model_class' => $this->dataClass,
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
