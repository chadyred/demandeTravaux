<?php

/*
    On hérite du contructeur de formulaire du bundle parent (FOSUserBundle) qui permet ainsi de rajouter ce que l'on désire au profil
 */

namespace Application\Sonata\UserBundle\Form\Type;

use Sonata\UserBundle\Form\Type\ProfileType as BaseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends BaseType
{
    
    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //On va ovveride la classe mère. On va récupérer son contenu, à savoir l'ensemble des champs qui seront modifier
        //déjà présent dans le constructeur de formulaire mère puis on va rajouter les nôtres : sexe, avatar...etc.
        parent::buildForm($builder, $options);

        $builder              
             ->add('civilite', 'entity', array(                 
                'label'    => 'Civilité',
                 'class' => 'MairieVoreppeDemandeTravauxBundle:Civilite',                 
                 'property' => 'abreviation'
                ))                
            ->remove('gender')
            ->remove('website')
            ->remove('biography')
            ->remove('locale')
            ->remove('timezone')
        ;
        
    }
    
     /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //On définie notre classe qui va nous permettre ici de récupérer l'ensembled es attribut
        $resolver->setDefaults(array(
            'data_class' => 'Application\Sonata\UserBundle\Entity\User'
        ));
    }
       
     /**
     * Cette fonction nous permet de nommé notre constructeur de formulaire afin de dire à la classe mère Profile que on 
     * va réaliser un formulaire qui modifiera, afficera les informations du profile via la classe ici présente.
     * NB : voir dans MairieVoreppe/UserBundle/Resources/config/services.yml pour la configuration du service 
     * dans la section 'fos_user'
     * 
     *
     * @return string
     */
    public function getName()
    {

        return 'mairievoreppe_user_profile';
    }    
}
