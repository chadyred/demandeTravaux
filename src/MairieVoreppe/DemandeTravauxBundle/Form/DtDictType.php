<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

class DtDictType extends AbstractType
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
     * 
     * RAppel: ici on traduit le fait que la DT lié à la DICT peut être CONJOINTE et ainsi le numéro de téléservice est unique.
      * Je ne reprends pas le formulaire de la DICT car certaines chose on du être modifiée, mais la copie se rapproche fortement
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dt', new DemandeTravauxType($this->user), array('label' => false))          
             ->add('numeroTeleservice', 'text', array('disabled' => true ))
            ->add('numeroAffaireDeclarant', 'text')
            ->add('duree', 'integer', array('required' => true, 'label' => 'Indiquez la durée en jour'))
            ->add('dateDebutTravaux',  'datetime')
            ->add('canalReception', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\CanalReception',
                'property' => 'libelle',
                'empty_data' => false,
                'placeholder' => '-'))
            ->add('maitreOeuvre', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Model\MaitreOeuvre',
                'empty_data' => false,
                'placeholder' => '-'))
            ->add('adresses', 'collection', array('type' => new AdresseType(),
                'allow_add' => true,
                'allow_delete' => true,
                'options' => array('required' => false),
                'label' => false
              ))            
            ->add('descriptionTravaux')
            ->add('noteComplementaire')
            ->add('dateReceptionDemande',  'datetime')
            ->add('dateReponseDemande',  'datetime')
            ->add('contactsUrgent', 'collection', array('type' => new ContactUrgentType(),
                'allow_add' => true,
                'allow_delete' => true,
                'options' => array('required' => false),
                'label' => false
              ))   
                //Tous ce passe ici: la dict est lié à la DT à laquelle il est attaché.
                ->add('dtDictConjointe', 'checkbox', array("data" => true, 
                    "attr" => array('hidden' => 'hidden'),
                    "label" => false))
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
         * Ceci va permettre de mettre un lien de suppression sur les les contact urgent créé
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
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_dtdict';
    }
}
