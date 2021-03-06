<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//On va mettre le namespace de notre méthode Classe interface Constraints de notre validator
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EmplacementReseauOuvrage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\EmplacementReseauOuvrageRepository")
 */
class EmplacementReseauOuvrage
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
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="echelle", type="string", length=255, nullable=true)
     */
    private $echelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEdition", type="datetime", nullable=true)
     */
    private $dateEdition;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sensible", type="boolean", nullable=true)
     */
    private $sensible;

    /**
     * @var string
     *
     * @ORM\Column(name="profondeurReglMini", type="decimal", nullable=true)
     */
    private $profondeurReglMini;

    /**
     * @var string
     *
     * @ORM\Column(name="materiauxReseau", type="text", nullable=true)
     */
    private $materiauxReseau;

    /**
    * Recepisse
    *
    * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Recepisse", inversedBy="emplacementsReseauOuvrage")
    * @ORM\JoinColumn(nullable=false)
    */
    private $recepisse;

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
     * Set reference
     *
     * @param string $reference
     *
     * @return EmplacementReseauOuvrage
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set echelle
     *
     * @param string $echelle
     *
     * @return EmplacementReseauOuvrage
     */
    public function setEchelle($echelle)
    {
        $this->echelle = $echelle;

        return $this;
    }

    /**
     * Get echelle
     *
     * @return string
     */
    public function getEchelle()
    {
        return $this->echelle;
    }

    /**
     * Set dateEdition
     *
     * @param \DateTime $dateEdition
     *
     * @return EmplacementReseauOuvrage
     */
    public function setDateEdition($dateEdition)
    {
        $this->dateEdition = $dateEdition;

        return $this;
    }

    /**
     * Get dateEdition
     *
     * @return \DateTime
     */
    public function getDateEdition()
    {
        return $this->dateEdition;
    }

    /**
     * Set sensible
     *
     * @param boolean $sensible
     *
     * @return EmplacementReseauOuvrage
     */
    public function setSensible($sensible)
    {
        $this->sensible = $sensible;

        return $this;
    }

    /**
     * Get sensible
     *
     * @return boolean
     */
    public function getSensible()
    {
        return $this->sensible;
    }

    /**
     * Set profondeurReglMini
     *
     * @param string $profondeurReglMini
     *
     * @return EmplacementReseauOuvrage
     */
    public function setProfondeurReglMini($profondeurReglMini)
    {
        $this->profondeurReglMini = $profondeurReglMini;

        return $this;
    }

    /**
     * Get profondeurReglMini
     *
     * @return string
     */
    public function getProfondeurReglMini()
    {
        return $this->profondeurReglMini;
    }

    /**
     * Set materiauxReseau
     *
     * @param string $materiauxReseau
     *
     * @return EmplacementReseauOuvrage
     */
    public function setMateriauxReseau($materiauxReseau)
    {
        $this->materiauxReseau = $materiauxReseau;

        return $this;
    }

    /**
     * Get materiauxReseau
     *
     * @return string
     */
    public function getMateriauxReseau()
    {
        return $this->materiauxReseau;
    }

    /**
     * Set recepisse
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $recepisse
     *
     * @return EmplacementReseauOuvrage
     */
    public function setRecepisse(\MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $recepisse)
    {
        $this->recepisse = $recepisse;

        return $this;
    }

    /**
     * Get recepisse
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Model\Recepisse
     */
    public function getRecepisse()
    {
        return $this->recepisse;
    }
}
