<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICT;

class RecepisseDTType extends RecepisseType
{
    protected $dataClass = 'MairieVoreppe\\DemandeTravauxBundle\\Entity\\RecepisseDT';
    public $entity;

    public function __construct($recepisseDt = null)
    {
        $this->entity = $recepisseDt;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
         $builder
            ->add('prevoirInvestiguation', "checkbox", array ("required" => false))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_recepissedt';
    }
}
