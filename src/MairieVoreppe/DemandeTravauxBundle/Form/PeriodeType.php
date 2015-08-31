<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MairieVoreppe\DemandeTravauxBundle\Entity\Mairie;

class PeriodeType extends AbstractType
{
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
        *
        * La date de fin n'est pas obligatoire
        */
        $builder
            ->add('responsableExploitant',  new ResponsableExploitantType())
            ->add('dateDebut',  'date', array("required" => true, 'format' => 'dd-MM-yyyy'))
            ->add('dateFin',  'date', array("required" => false, 'format' => 'dd-MM-yyyy'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Periode'
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
