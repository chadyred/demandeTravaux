<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;

class CivilType extends AbstractType
{
          
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Civilite',
                'property' => 'abreviation',
                "empty_data" => false,
                "placeholder" => "-"))
            ->add('nom')
            ->add('prenom')
                //Type phone_number
            ->add('telFixe', 'tel', array('default_region' => 'FR', 
                'format' => PhoneNumberFormat::NATIONAL))
            ->add('telMobile', 'tel', array('default_region' => 'FR', 
                'format' => PhoneNumberFormat::NATIONAL))
            ->add('email')
            ->add('adresse', new AdresseType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Civil'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_civil';
    }
}
