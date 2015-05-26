<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecepisseDT
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDTRepository")
 */
class RecepisseDT
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prevoirInvestiguation", type="boolean")
     */
    private $prevoirInvestiguation;


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
}

