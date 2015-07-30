<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICT;


class RecepisseDICTType extends ReponseType
{
    protected $dataClass = 'MairieVoreppe\\DemandeTravauxBundle\\Entity\\RecepisseDICT';

    private $entity;

    public function __construct($recepisseDict = null)
    {
        $this->entity=  $recepisseDict;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        parent::buildForm($builder, $options);         
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_recepissedict';
    }
}
