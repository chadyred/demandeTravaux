<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\Travaux;
	use Symfony\Component\Validator\Constraints as Assert;
//Permet de récupérer les valeur des objets en cours de vie dans notre classe
use Symfony\Component\Validator\ExecutionContextInterface;


/**
 * DemandeIntentionCT
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCTRepository")
 * @Assert\Callback(methods={"isDtDictConjointeValid" , "isDtValid"})
 */
class DemandeIntentionCT extends Travaux
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    
    /**
     * On garde les dicts même si l'entreprise est supprimée ! Si on decide de réutiliser ce dernier, on choisira une autre entreprise.
     * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise", inversedBy="dicts", cascade={"persist"})
     * 
     * @var type 
     */
    private $entreprise;
    
    /**
     * @var type
     *
     * Doctrine Array
     * 
     * Une dt et dict est conjointe lorsque les demande sont reçu sur le même formulaire.
     *      
     * @ORM\Column(name="dtDictConjointe", type="boolean") 
     */
    private $dtDictConjointe;
    
    
      /**
     * Doctrine Array
     * 
     * Pas de cascade étant donnée que la DT est créé au préalabe
     * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux", inversedBy="dicts")
     * @ORM\JoinColumn(nullable=true)
     * 
     * @var type 
     */
    private $dt;
    
    
    /**
     * Tout arrêté ne sera pas supprimable même si la DICT est supprimée. Et on ajoute un arretePromulge à une DICT.
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\ArretePromulgue", mappedBy="dict", cascade={"persist"})
     * 
     * @var type 
     */
    private $arretesPromulgues;
    
    /**
    * RecepisseDICT
    *
    * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICT", cascade={"persist"}, inversedBy="dict")
    * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
    */
    private $recepisseDict;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->arretesPromulgues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtDictConjointe = false;
    }
    
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Add maitresOeuvre
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise
     * @return DemandeIntentionCT
     */
    public function setEntreprise(\MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get maitresOeuvre
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }
   

    /**
     * Set dt
     *
     * Une DICT peut être seul
     * 
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux $dt
     * @return DemandeIntentionCT
     */
    public function setDt(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux $dt = null)
    {
        $this->dt = $dt;
        
        if($dt != null)
        {
            $dt->addDict($this);
        }
        else
        {
            $this->setDtDictConjointe(false);
        }
        
        return $this;
    }

    /**
     * Get dt
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux 
     */
    public function getDt()
    {
        return $this->dt;
    }

    /**
     * Add arretesPromulgue
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\ArretePromulgue $arretesPromulgue
     *
     * @return DemandeIntentionCT
     */
    public function addArretesPromulgue(\MairieVoreppe\DemandeTravauxBundle\Entity\ArretePromulgue $arretesPromulgue)
    {
        $this->arretesPromulgues[] = $arretesPromulgue;

        return $this;
    }

    /**
     * Remove arretesPromulgue
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\ArretePromulgue $arretesPromulgue
     */
    public function removeArretesPromulgue(\MairieVoreppe\DemandeTravauxBundle\Entity\ArretePromulgue $arretesPromulgue)
    {
        $this->arretesPromulgues->removeElement($arretesPromulgue);
    }

    /**
     * Get arretesPromulgues
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArretesPromulgues()
    {
        return $this->arretesPromulgues;
    }

 

    /**
     * Set dtDictConjointe
     *
     * @param boolean $dtDictConjointe
     *
     * @return DemandeIntentionCT
     */
    public function setDtDictConjointe($dtDictConjointe)
    {
        $this->dtDictConjointe = $dtDictConjointe;

        return $this;
    }

    /**
     * Get dtDictConjointe
     *
     * @return boolean
     */
    public function getDtDictConjointe()
    {
        return $this->dtDictConjointe;
    }
    
    /**
    * Condition de validation qui permet de vérifier lorsque l'on souhaite rendre une DICT conjointe, si la DT désiré n'est pas déjà conjointe à une autre. En générale
    * il s'agit d'une demande fait au début du dossier.
    */
    public function isDtValid(ExecutionContextInterface $context)
    {

        if($this->getDtDictConjointe() && $this->getDt() != NULL)
        {
            foreach($this->getDt()->getDicts() as $dict)
            {
               if($dict->getDtDictConjointe() && $dict->getId() != $this->getId())
               {
                    //Mise à jour
                    //$context->addViolationAt('duree', 'Veuillez indiquer une durée plus grande que 0 !', array(), null);            
                    $context->buildViolation('La DT n° <a target="_blank" href="{{ path("demandetravaux_edit", { "id" : {{ id }} } ) }}">{{ id }}</a> possède déjà une DICT conjointe, et ne peut en avoir qu\'une seule. Il faut au préalable retirer la DICT conjointe à la DT désirée !')
                            ->atPath('dt')
                            ->setParameter('{{ id }}', $this->getDt()->getId())
                            ->addViolation();
                    
               }
            }
        }                
    }
    
    /**
    * Condition de validation qui permet de vérifier lorsque l'on souhaite rendre une DICT conjointe, si la DT désiré n'est pas déjà conjointe à une autre. En générale
    * il s'agit d'une demande fait au début du dossier.
    */
    public function isDtDictConjointeValid(ExecutionContextInterface $context)
    {
        if($this->getDtDictConjointe())
        {
            if($this->getDt() == NULL)
            {
              
                    //Mise à jour
                    //$context->addViolationAt('duree', 'Veuillez indiquer une durée plus grande que 0 !', array(), null);            
                    $context->buildViolation('Veuillez choisir une DT avant !')
                            ->atPath('dtDictConjointe')
                            ->addViolation();
               
            }
        }                
    }

    /**
     * Set recepisseDict
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDict $recepisseDict
     *
     * @return DemandeIntentionCT
     */
    public function setRecepisseDict(\MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICT $recepisseDict = null)
    {
        $this->recepisseDict = $recepisseDict;

        return $this;
    }

    /**
     * Get recepisseDict
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDict
     */
    public function getRecepisseDict()
    {
        return $this->recepisseDict;
    }
}
