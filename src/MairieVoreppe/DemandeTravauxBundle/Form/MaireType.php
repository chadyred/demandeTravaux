<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;
use MairieVoreppe\DemandeTravauxBundle\Entity\Mairie;

class MaireType extends AbstractType
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
            ->add('noteDivers', 'text', array('required' => false))
            ->add('nom')
            ->add('prenom')
            ->add('telMobile', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, 'required' => false))
            ->add('email')
            ->add('telFixe', 'tel', array('default_region' => 'FR', 'format' => PhoneNumberFormat::NATIONAL, 'required' => false))
            ->add('adresse', new AdresseType())                
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Maire'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_maire';
    }
}
