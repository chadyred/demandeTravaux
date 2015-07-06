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
    * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Recepisse", mappedBy="miseHorsTension", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $recepisses;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recepisses = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function addRecepiss(\MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $recepisse)
    {
        $this->recepisses[] = $recepisse;

        return $this;
    }

    /**
     * Remove emplacementsReseauOuvrage
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $emplacementsReseauOuvrage
     */
    public function removeRecepiss(\MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $recepisse)
    {
        $this->recepisses->removeElement($recepisse);
    }

    /**
     * Get emplacementsReseauOuvrage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecepisses()
    {
        return $this->recepisses;
    }
}
