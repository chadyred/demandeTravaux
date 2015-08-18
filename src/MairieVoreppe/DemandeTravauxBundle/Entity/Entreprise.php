<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\PersonneMorale;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Entreprise
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
     * Constructor
     */
    public function __construct()
    {
        $this->dicts = new \Doctrine\Common\Collections\ArrayCollection();
    }
     
   
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
}
