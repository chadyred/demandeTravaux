<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MiseHorsTension
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\MiseHorsTensionRepository")
 */
class MiseHorsTension
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;


   /**
    * Recepisse
    *
    * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Recepisse", mappedBy="miseHorsTension")
    * @ORM\JoinColumn(nullable=false)
    */
    protected $emplacementsReseauOuvrage;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->emplacementsReseauOuvrage = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return MiseHorsTension
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Add emplacementsReseauOuvrage
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $emplacementsReseauOuvrage
     *
     * @return MiseHorsTension
     */
    public function addEmplacementsReseauOuvrage(\MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $emplacementsReseauOuvrage)
    {
        $this->emplacementsReseauOuvrage[] = $emplacementsReseauOuvrage;

        return $this;
    }

    /**
     * Remove emplacementsReseauOuvrage
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $emplacementsReseauOuvrage
     */
    public function removeEmplacementsReseauOuvrage(\MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $emplacementsReseauOuvrage)
    {
        $this->emplacementsReseauOuvrage->removeElement($emplacementsReseauOuvrage);
    }

    /**
     * Get emplacementsReseauOuvrage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmplacementsReseauOuvrage()
    {
        return $this->emplacementsReseauOuvrage;
    }
}
