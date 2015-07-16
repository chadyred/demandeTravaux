<?php

namespace MairieVoreppe\UserBundle\Form\Type;

use Sonata\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends BaseType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

         //On va alors récupérer du parent la méthode qui construit le constructeur de formulaire et on passse
        //nos deux paramêtre de notre méthode buildForm, et ainsi on aura tout les champs du constructeur parent
        parent::buildForm($builder, $options);
            //Ce champs est dans mon entité user. Je vais donc le traité ici présent
        $builder
             ->add('civilite', 'entity', array(
                 'class' => 'MairieVoreppeDemandeTravauxBundle:Civilite',                 
                 'property' => 'abreviation',
                 ))
            ->add('gender', 'choice', array('required' => true, 'choices' => array('f' => 'fille', 'm' => 'garçon'), 'expanded' => true, 'error_bubbling' => true))
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_user_registration';
    }
}