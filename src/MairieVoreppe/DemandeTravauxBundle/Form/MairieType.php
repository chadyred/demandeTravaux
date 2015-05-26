<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;

class MairieType extends AbstractType
{
       /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
        <div id="locationField">
      <input id="autocomplete" placeholder="Enter your address"
             onFocus="geolocate()" type="text"></input>
    </div>
    */
        $builder
            ->add('siret')
            ->add('raisonSociale')
            ->add('complement', 'text', array('required' => false))
            ->add('service', 'text', array('required' => false))
            ->add('telFax', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, 'required' => false))
            ->add('telFixe', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, 'required' => false))
            ->add('logo', new LogoType(), array('required' => false))
            ->add('adresse', new AdresseType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Mairie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_mairie';
    }
}
