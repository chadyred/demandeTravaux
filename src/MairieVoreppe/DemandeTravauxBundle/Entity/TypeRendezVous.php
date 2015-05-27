<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeRendezVous
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\TypeRendezVousRepository")
 */
class TypeRendezVous
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
     * @ORM\Column(name="libelle", type="text")
     */
    private $libelle;

    /**
    * @var rendezVous
    *
    * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\RendezVous", mappedBy="typeRendezVous")
    */
    protected $rendezVous;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rendezVous = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return TypeRendezVous
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
     * Add rendezVous
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\RendezVous $rendezVous
     *
     * @return TypeRendezVous
     */
    public function addRendezVous(\MairieVoreppe\DemandeTravauxBundle\Entity\RendezVous $rendezVous)
    {
        $this->rendezVous[] = $rendezVous;

        return $this;
    }

    /**
     * Remove rendezVous
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\RendezVous $rendezVous
     */
    public function removeRendezVous(\MairieVoreppe\DemandeTravauxBundle\Entity\RendezVous $rendezVous)
    {
        $this->rendezVous->removeElement($rendezVous);
    }

    /**
     * Get rendezVous
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRendezVous()
    {
        return $this->rendezVous;
    }
}
