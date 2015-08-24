<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArretePromulgue
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\ArretePromulgueRepository")
 */
class ArretePromulgue
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
     * @var DemandeIntentionCT
     *
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT", inversedBy="arretesPromulgues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dict;

    /**
     * @var ArreteModel
     *
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\ArreteModel", inversedBy="arretesPromulgues")
     */
    private $arreteModel;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;
    
    public function __construct() {
        $this->dateCreation = new \DateTime();
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
     * Set dict
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict
     *
     * @return ArretePromulgue
     */
    public function setDict(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict = null)
    {
        $this->dict = $dict;

        return $this;
    }

    /**
     * Get dict
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT
     */
    public function getDict()
    {
        return $this->dict;
    }

    /**
     * Set arreteModel
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\ArreteModel $arreteModel
     *
     * @return ArretePromulgue
     */
    public function setArreteModel(\MairieVoreppe\DemandeTravauxBundle\Entity\ArreteModel $arreteModel = null)
    {
        $this->arreteModel = $arreteModel;

        return $this;
    }

    /**
     * Get arreteModel
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\ArreteModel
     */
    public function getArreteModel()
    {
        return $this->arreteModel;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }
}
