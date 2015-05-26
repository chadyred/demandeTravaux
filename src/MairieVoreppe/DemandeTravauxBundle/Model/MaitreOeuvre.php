<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 * 
 * @ORM\Entity
 * 
 */
abstract class MaitreOeuvre extends Intervenant
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
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT", mappedBy="maitreOeuvre")
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * Add dicts
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dicts
     * @return MaitreOeuvre2
     */
    public function addDict(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dicts)
    {
        $this->dicts[] = $dicts;

        return $this;
    }

    /**
     * Remove dicts
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dicts
     */
    public function removeDict(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dicts)
    {
        $this->dicts->removeElement($dicts);
    }
}
