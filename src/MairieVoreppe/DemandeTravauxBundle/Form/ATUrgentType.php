<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

class ATUrgentType extends AbstractType
{
       private $user;

      //Le user vaut null lorsque l'on édit. en effet, on veut uniquement récupérer celui qui créer le travaux,
      // afin de proposer UNIQUEMENT les services au seind esquels il travail
      public function __construct($user = null)
      {
          $this->user = $user;
      }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroTeleservice', null, array("required" => true))
            ->add('dateDebutTravaux', 'date', array("required" => false, 'format' => 'dd-MM-yyyy'))
            ->add('duree', 'integer', array('required' => true, 'label' => 'Indiquez la durée en jour'))
            //placeholder remplace empty_value de 2.6
            ->add('canalReception', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\CanalReception',
                'property' => 'libelle',
                'empty_data' => false,
                'placeholder' => '-', 
                "required" => false))         
            ->add('descriptionTravaux', null, array("required" => false))
            ->add('noteComplementaire', null, array("required" => false))
            ->add('dateReceptionDemande', 'date', array("required" => true, 'format' => 'dd-MM-yyyy'))
            ->add('dateReponseDemande',  'date', array("required" => false, 'format' => 'dd-MM-yyyy'))
            ->add('contactsUrgent', 'collection', array('type' => new ContactUrgentType(),
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
              ))    
            ->add('adresses', 'collection', array('type' => new AdresseType(),
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
              ))  
        ;
        
        /**
         * Ceci va permettre de mettre un lien de suppression uniquement sur les autres car la première adresse est obligatoire
         */
         $builder->get('adresses')->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $adresses = $event->getData();
                $form = $event->getForm();
                
                for($i = 1;count($adresses) > $i;$i++)
                {
                     $form->get($i)
                          ->add('delete', 'submit');
                }
       
        });
        
         /**
         * Ceci va permettre de mettre un lien de suppression sur les les contact urgent créé avant le chargement du formulaire
         */
         $builder->get('contactsUrgent')->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $contactsUrgent = $event->getData();
                $form = $event->getForm();
                
                for($i = 0;count($contactsUrgent) > $i;$i++)
                {
                     $form->get($i)
                          ->add('delete', 'submit');
                }
       
        });

         /**
         * Evènement qui permet d'afficher le champs du service lié à l'exploitant pour un travaux. Lors de l'édition on empĉhe sa modification
         * et on ne retient pas l'utilisateur en cours parce que celle-ci dépend de celui qui a créé la demande, et seul l'administrateur 
         * peut en changer le service lié à l'exploitant
         *
         */
          $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $form = $event->getForm();
          if($this->user == null)
          {
            $form
            ->add('serviceExploitant', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant",
                'multiple' => false,
                'expanded' => false,
                'empty_data' => false,
                'placeholder' => '-',
                'read_only' => true,
                'disabled' => true
              ));
          }
          else
          {
              $form
                ->add('serviceExploitant', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant",
                    'multiple' => false,
                    'expanded' => false,
                    'empty_data' => false,
                    'placeholder' => '-',
                    //requête qui garde les exploitants dont les services sont similaires à ceux dans lesquelles sont les utilisateurs
                    'query_builder' => function (EntityRepository $er ) {
                      return $er->createQueryBuilder('se')
                                ->join('se.service', 's')
                                ->addSelect('s')
                                ->join('s.users', 'u')
                                ->where('u.id = :user_id')
                                ->setParameter('user_id', $this->user->getId());
                                }
                      ));
          }
      }); 
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\ATUrgent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_aturgent';
    }
}
