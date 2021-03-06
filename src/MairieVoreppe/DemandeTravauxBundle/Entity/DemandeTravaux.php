<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\Travaux;
use JMS\Serializer\Annotation\Groups;
    use Symfony\Component\Validator\Constraints as Assert;

/**
 * DemandeTravaux
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravauxRepository")
 */
class DemandeTravaux extends Travaux
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
     * @Groups({"dt"})
     */
    protected $dateDebutTravaux;

     /**
     * @Groups({"dateDeb"})
     */
    protected $duree;

     /**
     * @Groups({"dt"})
     */
    protected $descriptionTravaux;

     /**
     * @Groups({"dt"})
     */
    protected $noteComplementaire;

     /**
     * @Groups({"dt"})
     */
    protected $contactsUrgent; 

     /**
     * @Groups({"dt"})
     */
    protected $adresses; 

     /**
     * @Groups({"dt"}) 
     */
    protected $canalReception; 

    
    
    /**
     * Doctrine Array
     * 
     * Toute les DICT sont supprimées en cascade si la DT est supprimée le sont
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT", mappedBy="dt", cascade={"persist", "remove"})
     * 
     * @var type 
     */
    private $dicts;
    
    /**
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Declarant", inversedBy="dts")
     * 
     * @var type 
     */
    private $declarant;
   
   /**
    * RecepisseDt : récpissé résultant d'un traitement sur cette entité
    *
    * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT", cascade={"persist"}, inversedBy="dt")
    * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
    */
    private $recepisseDt;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * Add declarant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Declarant $declarant
     * @return DemandeTravaux
     */
    public function setDeclarant(\MairieVoreppe\DemandeTravauxBundle\Model\Declarant $declarant)
    {
        $this->declarant = $declarant;

        return $this;
    }

    /**
     * Get maitresOuvrage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDeclarant()
    {
        return $this->declarant;
    }
   

    /**
     * Add dicts
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dicts
     * @return DemandeTravaux
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

    /**
     * Get dicts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDicts()
    {
        return $this->dicts;
    }

  

    /**
     * Set recepisseDt
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDt $recepisseDt
     *
     * @return DemandeTravaux
     */
    public function setRecepisseDt(\MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT $recepisseDt = null)
    {
        $this->recepisseDt = $recepisseDt;

        return $this;
    }

    /**
     * Get recepisseDt
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDt
     */
    public function getRecepisseDt()
    {
        return $this->recepisseDt;
    }
}