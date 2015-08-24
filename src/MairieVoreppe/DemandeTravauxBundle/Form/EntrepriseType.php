<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class EntrepriseType extends AbstractType
{
      private $entrepriseDict;

      public function __construct($entrepriseDict = false)
      {
        $this->entrepriseDict = $entrepriseDict;
      }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siret')
            ->add('raisonSociale')
            ->add('complement')
            ->add('service')   
                //Type phone_number         
            ->add('telFax', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL))
            ->add('telFixe', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL))
            ->add('statutJuridique', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\StatutJuridique',
                'property' => 'abreviation',
                'empty_data' => true,
                'placeholder' => '-'))
            ->add('adresse', new AdresseType())
            ->add('gerant', new GerantType())
        ;

         $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $form = $event->getForm();

            if($this->entrepriseDict == false)
            {
                $form
                    ->add('prestataireDICT', 'checkbox', array(
                        'label' => "Prestataire DICT?",
                        "required" => false));
            }
            else
            {
                 $form
                    ->add('prestataireDICT', 'checkbox', array(
                        'label' => false,
                        'data' => $this->entrepriseDict,
                        "attr" => array("hidden" => "hidden"),
                        "required" => false));
            }
        });

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_entreprise';
    }
}
