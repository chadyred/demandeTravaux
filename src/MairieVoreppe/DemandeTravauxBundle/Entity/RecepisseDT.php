<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\Recepisse;
use JMS\Serializer\Annotation\Groups;

/**
 * RecepisseDT
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDTRepository")
 */
class RecepisseDT extends Recepisse
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
     * @var boolean
     *
     * @ORM\Column(name="prevoirInvestiguation", type="boolean")
     */
    private $prevoirInvestiguation;

    public function __construct()
    {
        parent::__construct();
    }

    
   /**
    * RecepisseDT
    *
    * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux", mappedBy="recepisseDt")
    */
    private $dt;

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
     * Set prevoirInvestiguation
     *
     * @param boolean $prevoirInvestiguation
     *
     * @return RecepisseDT
     */
    public function setPrevoirInvestiguation($prevoirInvestiguation)
    {
        $this->prevoirInvestiguation = $prevoirInvestiguation;

        return $this;
    }

    /**
     * Get prevoirInvestiguation
     *
     * @return boolean
     */
    public function getPrevoirInvestiguation()
    {
        return $this->prevoirInvestiguation;
    }

    /**
     * Set dt
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux $dt
     *
     * @return RecepisseDT
     */
    public function setDt(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux $dt)
    {
        $this->dt = $dt;

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

    
   
}
