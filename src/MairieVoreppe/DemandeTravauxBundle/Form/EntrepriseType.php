<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;

class EntrepriseType extends AbstractType
{
     
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
                'property' => 'abreviation'))
            ->add('adresse', new AdresseType())
            ->add('gerant', new GerantType())
        ;
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
