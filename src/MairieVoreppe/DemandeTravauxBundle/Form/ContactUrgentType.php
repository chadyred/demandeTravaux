<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;

class ContactUrgentType extends AbstractType
{
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Civilite',
                'property' => 'abreviation'))
            ->add('nom', 'text', array('required' => true, "required" => false))
            ->add('prenom', 'text', array("required" => false))
            ->add('telFixe', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, "required" => false))
            ->add('telMobile', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, "required" => false))
            ->add('email')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_contacturgent';
    }
}
