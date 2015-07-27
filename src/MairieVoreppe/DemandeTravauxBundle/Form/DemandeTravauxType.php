<?php

namespace MairieVoreppe\DemandeTravauxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\ORM\EntityRepository;

class DemandeTravauxType extends AbstractType
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
            ->add('serviceExploitant', "entity", array('class' => "MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant",
                "property" => 'exploitant.raisonSociale',
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
              ))
            ->add('numeroTeleservice')
            ->add('numeroAffaireDeclarant', 'text')
            ->add('dateDebutTravaux',  'datetime')
            ->add('duree', 'integer', array('required' => true, 'label' => 'Indiquez la durée en jour'))
            ->add('canalReception', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\CanalReception',
                'property' => 'libelle',
                'empty_data' => false,
                'placeholder' => '-'
              ))
            ->add('maitreOuvrage', 'entity', array('class' => 'MairieVoreppe\DemandeTravauxBundle\Model\MaitreOuvrage',
                'empty_data' => false,
                'placeholder' => '-'
              ))            
            ->add('adresses', 'collection', array('type' => new AdresseType(),
                'allow_add' => true,
                'allow_delete' => true,
                'options' => array('required' => false),
                'label' => false,
              ))            
            ->add('descriptionTravaux')
            ->add('noteComplementaire')
            ->add('dateReceptionDemande', 'datetime')
            ->add('dateReponseDemande', 'datetime')
            ->add('contactsUrgent', 'collection', array('type' => new ContactUrgentType(),
                'allow_add' => true,
                'allow_delete' => true,
                'options' => array('required' => false),
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
        
         $builder->get('contactsUrgent')->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $contactsUrgent = $event->getData();
                $form = $event->getForm();
                
                for($i = 0;count($contactsUrgent) > $i;$i++)
                {
                     $form->get($i)
                          ->add('delete', 'submit');
                }
       
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mairievoreppe_demandetravauxbundle_demandetravaux';
    }
}
