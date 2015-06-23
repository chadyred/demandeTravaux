<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class DtDictType extends AbstractType
{
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * 
     * RAppel: ici on trduit le fait que la DT lié à la DICT peut être lié et ainsi le numéro de téléservice est unique
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dt', new DemandeTravauxType(), array('label' => false))
             ->add('numeroTeleservice', 'text', array('disabled' => true ))
            ->add('duree', 'integer', array('required' => true, 'label' => 'Indiquez la durée en jour'))
            ->add('dateDebutTravaux',  'datetime')
            ->add('canalReception', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\CanalReception',
                'property' => 'libelle',
                'empty_data' => false,
                'placeholder' => '-'))
            ->add('maitreOeuvre', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Model\MaitreOeuvre',
                'empty_data' => false,
                'placeholder' => '-'))
            ->add('adresses', 'collection', array('type' => new AdresseType(),
                'allow_add' => true,
                'allow_delete' => true,
                'options' => array('required' => false),
                'label' => false,
              ))            
            ->add('descriptionTravaux')
            ->add('noteComplementaire')
            ->add('dateReceptionDemande',  'datetime')
            ->add('dateReponseDemande',  'datetime')
            ->add('contactsUrgent', 'collection', array('type' => new ContactUrgentType(),
                'allow_add' => true,
                'allow_delete' => true,
                'options' => array('required' => false),
                'label' => false
              ))   
                //Tous ce passe ici: la dict est lié à la DT à laquelle il est attaché.
                ->add('dtDictConjointe', 'checkbox', array("data" => true, 
                    "attr" => array('hidden' => 'hidden'),
                    "label" => false))
        ;
        
         /**
         * Ceci va permettre de mettre un lien de suppression uniquement sur les autres car la première adresse est obligatoire
         */
         $builder->get('adresses')->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $adresses = $event->getData();
                $form = $event->getForm();
                
                for($i = 1;count($adresses) > $i;$i++)
                {
                     $form->get($i)
                          ->add('delete', 'submit');
                }
       
        });
        
         /**
         * Ceci va permettre de mettre un lien de suppression sur les les contact urgent créé
         */
         $builder->get('contactsUrgent')->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $contactsUrgent = $event->getData();
                $form = $event->getForm();
                
                for($i = 0;count($contactsUrgent) > $i;$i++)
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
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_dtdict';
    }
}
