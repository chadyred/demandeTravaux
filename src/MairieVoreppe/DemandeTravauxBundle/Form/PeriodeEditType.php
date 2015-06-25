<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MairieVoreppe\DemandeTravauxBundle\Entity\Mairie;
use MairieVoreppe\DemandeTravauxBundle\Entity\Maire;

class PeriodeEditType extends PeriodeType
{
    private $maire;
    
    public function __construct(Maire $unMaire)
    {
        $this->maire = $unMaire;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //TODO:  passer l'objet directement via le controller au travers de l'en-tête du formulaire.
        parent::buildForm($builder, $options);
        $builder
            ->add('maire', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Maire',
                'property' => 'nom',
                'data' => $this->maire,
                'attr' => array('class' => 'hidden'),//Je cache ce champ puisque chaque periode créé correspondra au MAIRE constement en cours d'édition
                'label' => false)) //'label' => false permet de retirer le nom de l'entité qui apparait puisuq'ici on cache le maire puisque l'on a les info au dessus
            ->add('mairie', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Mairie',
                'property' => 'raisonSociale',
                'label' => 'de la mairie'))
             ->add('delete', 'submit')
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
