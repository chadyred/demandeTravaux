<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\PersonneMorale;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Entreprise
 *
 * Classe qui représente une entreprise.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\EntrepriseRepository")
 */
class Entreprise extends PersonneMorale
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
     * @var type Ville
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT", mappedBy="entreprise")
     */
    protected $dicts;
     
   
     /**
     * @var \
     * 
     * Privé à cette classe.
      * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Gerant", inversedBy="entreprise", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $gerant;
    
      /**
     * @var \
     * 
     * Privé à cette classe.
      * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\StatutJuridique", inversedBy="entreprises")
     */
    private $statutJuridique;
    
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection() 
     * 
     * 
     * 
     * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMorale", cascade={"remove", "persist"}, orphanRemoval=true)
     */
    private $moePersonneMorale; 
    

    /**
    * @var boolean
    *
    *
    * Toute entreprise peut prétendre à être prestataire ou non ! Les entreprise créé par défaut le son par défaut.
    *
    * @ORM\column(name="prestataire_dict", type="boolean", nullable=false)
    *
    */
    private $prestataireDICT;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dicts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set gerant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Gerant $gerant
     * 
     * On ajoute un gérant à l'entreprise, il sera persisté en cascade lorsque l'entité sera hydratée
     * 
     * @return Entreprise
     */
    public function setGerant(\MairieVoreppe\DemandeTravauxBundle\Entity\Gerant $gerant = null)
    {
        $this->gerant = $gerant;
        $gerant->addEntreprises($this);

        return $this;
    }

    /**
     * Get gerant
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Gerant 
     */
    public function getGerant()
    {
        return $this->gerant;
    }
 
    /**
     * Set statutJuridique
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\StatutJuridique $statutJuridique
     * @return Entreprise
     */
    public function setStatutJuridique(\MairieVoreppe\DemandeTravauxBundle\Entity\StatutJuridique $statutJuridique = null)
    {
        $this->statutJuridique = $statutJuridique;

        return $this;
    }

    /**
     * Get statutJuridique
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\StatutJuridique 
     */
    public function getStatutJuridique()
    {
        return $this->statutJuridique;
    } 

    /**
     * Add dict
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict
     * @return DemandeIntentionCT
     */
    public function addDicts(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict)
    {
        $this->dicts[] = $dict;

        return $this;
    }

    /**
     * Remove dict
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict
     */
    public function removeDicts(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict)
    {
        $this->dicts->removeElement($dict);
    }

    /**
     * Get dtDict
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDicts()
    {
        return $this->dicts;
    }

    public function __toString()
    {
        $toString = "";

        $toString = $this->getRaisonSociale() . ' ' . $this->getStatutJuridique()->getAbreviation();

        return $toString;
        
    }

    /**
     * Add dict
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict
     *
     * @return Entreprise
     */
    public function addDict(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict)
    {
        $this->dicts[] = $dict;

        return $this;
    }

    /**
     * Remove dict
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict
     */
    public function removeDict(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict)
    {
        $this->dicts->removeElement($dict);
    }

    /**
     * Set moePersonneMorale
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMorale $moePersonneMorale
     *
     * @return Entreprise
     */
    public function setMoePersonneMorale(\MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMorale $moePersonneMorale = null)
    {
        $this->moePersonneMorale = $moePersonneMorale;

        return $this;
    }

    /**
     * Get moePersonneMorale
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMorale
     */
    public function getMoePersonneMorale()
    {
        return $this->moePersonneMorale;
    }

     /**
     * Set prestataireDICT
     *
     * @param boolean $prestataireDICT
     *
     * @return MOEPersonneMorale
     */
    public function setPrestataireDICT($prestataireDICT)
    {
        $this->prestataireDICT = $prestataireDICT;

        return $this;
    }

    /**
     * Get prestataireDICT
     *
     * @return boolean
     */
    public function getPrestataireDICT()
    {
        return $this->prestataireDICT;
    }
}
