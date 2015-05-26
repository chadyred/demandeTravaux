<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique;

/**
 * Maire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\MaireRepository")
 */
class Maire extends PersonnePhysique
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
     * @var string
     *
     * @ORM\Column(name="noteDivers", type="text", nullable=true)
     */
    protected $noteDivers;
    
    
     /**
     * @var \
     * 
      * orphanRemoval supprimera totue les période du maire supprimé, puisuq'une période doit avoir une mairie ET UN MAIRE
      * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Periode", mappedBy="maire", orphanRemoval=true, cascade={"remove", "persist"})
     */
    protected $periodes;

    public function __construct()
    {
        $this->periodes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set noteDivers
     *
     * @param string $noteDivers
     * @return Maire
     */
    public function setNoteDivers($noteDivers)
    {
        $this->noteDivers = $noteDivers;

        return $this;
    }

    /**
     * Get noteDivers
     *
     * @return string 
     */
    public function getNoteDivers()
    {
        return $this->noteDivers;
    }

    /**
     * Add periodes
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Periode $periodes
     * @return Maire
     */
    public function addPeriodes(\MairieVoreppe\DemandeTravauxBundle\Entity\Periode $periode)
    {
        $this->periodes[] = $periode;
        $periode->setMaire($this);

        return $this;
    }

    /**
     * Remove periodes
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Periode $periodes
     */
    public function removePeriodes(\MairieVoreppe\DemandeTravauxBundle\Entity\Periode $periode)
    {
        $this->periodes->removeElement($periode);
    }

    /**
     * Get periodes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPeriodes()
    {
        return $this->periodes;
    }
}
