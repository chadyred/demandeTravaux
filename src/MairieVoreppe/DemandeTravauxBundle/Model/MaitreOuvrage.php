<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 * 
 * @ORM\Entity
 * 
 */
abstract class MaitreOuvrage extends Intervenant
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
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux", mappedBy="maitreOuvrage")
     */
    protected $dts;
    
    
    
     
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add dts
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux $dts
     * @return MaitreOuvrage
     */
    public function addDt(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux $dts)
    {
        $this->dts[] = $dts;

        return $this;
    }

    /**
     * Remove dts
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux $dts
     */
    public function removeDt(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux $dts)
    {
        $this->dts->removeElement($dts);
    }

    /**
     * Get dts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDts()
    {
        return $this->dts;
    }
    

    
     
}
