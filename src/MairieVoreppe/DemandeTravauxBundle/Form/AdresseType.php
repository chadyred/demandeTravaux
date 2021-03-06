<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Ivory\GoogleMap\Places\AutocompleteComponentRestriction;
use Ivory\GoogleMap\Places\AutocompleteType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class AdresseType extends AbstractType
{
    
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('autocomplete', 'text', array('mapped' => false, 'required' => false,
                "attr" => array('autocomplete' => 'autocomplete',
                                "onFocus" => "geolocate()",
                                "placeholder" => "Saisissez une adresse")))
            ->add('numeroRue', 'text', array("required" => false, 'attr' => array('street_number' => 'street_number')))
            ->add('adresse', 'text', array("required" => false, 'attr' => array('route' => 'route')))
            ->add('complementAdresse', 'text',  array('required' => false))
            ->add('lieuDit', 'text',  array('required' => false, 'attr' => array('lieuDit' => 'lieuDit')))       
            ->add('ville', 'text', array('required' => false, 'attr' => array('locality' => 'locality')))
            ->add('cp', 'text', array('required' => false, 'attr' => array('postal_code' => 'postal_code')))
            ->add('pays', 'text', array('required' => false, 'attr' => array('country' => 'country')))
        ;
                
          
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Adresse'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_adresse';
    }
}
