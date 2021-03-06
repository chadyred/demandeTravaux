<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

class DemandeIntentionCTType extends AbstractType
{
    
    private $user;
    private $dt;
    private $dtDict;

    // Permet de récupérer les entreprise au travers d'une requête. Cette dernière est appelé au sein du controller de la DICT.
    private $entreprises;

    /**
     * On peut préciser s'il d'agit d'une dict lié avec une DT, auquel cas le numéro de téléservice sera le même
     * ou bien on peut ajouter une DICT à une DT, on peut alors préciser laquelle au travers d'une liste
     */
    public function __construct($dtDict = false, $dt= null, $user = null, $entreprises)
    {
        $this->dtDict = $dtDict;
        $this->dt = $dt;
        $this->user = $user;
        $this->entreprises = $entreprises;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroTeleservice', 'text', array('disabled' => $this->dtDict, "required" => true ))
            ->add('numeroAffaireDeclarant', 'text', array(
                "required" => false ))
            ->add('dateDebutTravaux', 'date', array(
                            "required" => false, 'format' => 'dd-MM-yyyy' ))
            ->add('duree', 'integer', array('required' => false, 
              'label' => 'Indiquez la durée en jour'))
            ->add('canalReception', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\CanalReception',
                'property' => 'libelle',
                'empty_data' => false,
                'placeholder' => '-'))
            ->add('entreprise', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise',
                'empty_data' => false,
                'placeholder' => '-',
                 'query_builder' => function (EntityRepository $er ) {
                        return $er->getEntreprisePrestataire();
                            }
                        ))
            ->add('adresses', 'collection', array('type' => new AdresseType(),
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false
              ))            
            ->add('descriptionTravaux', 'text', array("required" => false))
            ->add('noteComplementaire', 'text', array("required" => false))
            ->add('dateReceptionDemande','date', array( 
              "required" => true, 'format' => 'dd-MM-yyyy',
              "attr" => array('data-provide'=>"datepicker", 
                "data-date-format"=>"dd/mm/yyyy", "data-date-language" => "fr")
              ))
            ->add('dateReponseDemande', 'date', array('disabled'=> true, 
                "read_only"=> true, 
                'empty_data' => true,
                'placeholder' => '-',
                'format' => 'dd-MM-yyyy'
              ))
            ->add('contactsUrgent', 'collection', array('type' => new ContactUrgentType(),
                'allow_add' => true,
                'allow_delete' => true,
                'options' => array('required' => false),
                'label' => false
              ))      
            ->add('dtDictConjointe', 'choice', array('choices' => array('0' => 'Non', '1' => 'Oui'),
                     'label' => 'DT conjointe lié à sa DICT ?'))
        ;
        
        //Permet de gérer avant le chargement du formulaire si des champs ou des données doivent être changer AVANT l'hydratation du formulaire. Ici ce sera le 
        //cas lorsque l'on va créer une DICT pour une DT, on ne permet pas de changer de DT.
        //En HTML, un champ disable n'est pas validée. En outre, si on est en présence d'une DT liée à une DICT, ce champs sera inactif,
        //or il faut tout de même validée à quel DT il est rattaché.
        //Il faut donc le blocké avec la condition ternaire puis le déblocké par la suite avec l'évènement du formulaire PRE_SET_DATA
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            
        $dict = $event->getData();
        $form = $event->getForm();
        $formAdresse = $event->getForm()->get('adresses');
            
        //Si on a une DT on ne disable pas le champs, on le cache avec sa valeur en read_only afin d'automatiser l'hydratation, puis on indique le numéro lié 
        //de DT
            if($this->dt != null)
            {
                $form
                    ->add('numeroDemandeTravauxLiee', 'text', array('mapped' => false, 'data' => $this->dt->getNumeroTeleservice(), 'disabled' => true)) //'label' => false permet de retirer le nom de l'entité qui apparait puisuq'ici on cache le maire puisque l'on a les info au dessus
                    ->add('dt', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux',
                        'property' => 'numeroTeleservice',
                        'data' => $this->dt,
                        'label' => false,
                        'label' => 'Numéro demande travaux lié',
                        'empty_data' => null,
                        'placeholder' => '-',
                        'read_only' => true
                       ));
                   
            }
            else
            {
             //une dt peut être null pour un DICT, en effet une DICT peut être créée sans DT.
                $form
                    ->add('dt', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux',
                    'required' => false,	
                    'multiple' => false, 
                    'expanded' => false,
                    'property' => 'numeroTeleservice',
                    'label' => 'Numéro demande travaux lié',
                    'empty_data' => null,
                    'placeholder' => '-',
                    'disabled' => false,
                    'read_only' => false)); //'label' => false permet de retirer le nom de l'entité qui apparait puisuq'ici on cache le maire puisque l'on a les info au dessus
            }
                
               
               
        });
        
        /**
         * Ceci va permettre de mettre un lien de suppression uniquement sur les autres car la première adresse est obligatoire
         */
         $builder->get('adresses')->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $adresses = $event->getData();
                $form = $event->getForm();
                
                for($i = 0;count($adresses) > $i;$i++)
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
                'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT',
               'empty_data' => function (FormInterface $form) {
                return null;
             },
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_demandeintentionct';
    }
}
