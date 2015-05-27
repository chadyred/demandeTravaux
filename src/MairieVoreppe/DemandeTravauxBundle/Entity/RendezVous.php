<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RendezVous
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\RendezVousRepository")
 */
class RendezVous
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateRetenue", type="datetime")
     */
    private $dateRetenue;

   /**
    * Recepisse
    *
    * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\TypeRendezVous", inversedBy="rendezVous")
    * @ORM\JoinColumn(nullable=false)
    */
    protected $typeRendezVous;


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
     * Set dateRetenue
     *
     * @param \DateTime $dateRetenue
     *
     * @return RendezVous
     */
    public function setDateRetenue($dateRetenue)
    {
        $this->dateRetenue = $dateRetenue;

        return $this;
    }

    /**
     * Get dateRetenue
     *
     * @return \DateTime
     */
    public function getDateRetenue()
    {
        return $this->dateRetenue;
    }

    /**
     * Set typeRendezVous
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\TypeRendezVous $typeRendezVous
     *
     * @return RendezVous
     */
    public function setTypeRendezVous(\MairieVoreppe\DemandeTravauxBundle\Entity\TypeRendezVous $typeRendezVous)
    {
        $this->typeRendezVous = $typeRendezVous;

        return $this;
    }

    /**
     * Get typeRendezVous
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\TypeRendezVous
     */
    public function getTypeRendezVous()
    {
        return $this->typeRendezVous;
    }
}
