<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Periode
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\PeriodeRepository")
 */
class Periode
{
   /**
    * @var \integeer
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;
    
     /**
     * @var \$responsableExploitant 
    * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\ResponsableExploitant", inversedBy="periodes", cascade={"persist"})
     */
    private $responsableExploitant;
    
     /**
     * @var \$mairie
      * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant", inversedBy="periodes")
     */
    private $exploitant;
    

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;


    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Periode
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Periode
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
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
     * Set responsableExploitant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\ResponsableExploitant $responsableExploitant
     *
     * @return Periode
     */
    public function setResponsableExploitant(\MairieVoreppe\DemandeTravauxBundle\Entity\ResponsableExploitant $responsableExploitant)
    {
        $this->responsableExploitant = $responsableExploitant;
        $responsableExploitant->addPeriodes($this);


        return $this;
    }

    /**
     * Get responsableExploitant
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\ResponsableExploitant
     */
    public function getResponsableExploitant()
    {
        return $this->responsableExploitant;
    }

    /**
     * Set exploitant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant $exploitant
     *
     * @return Periode
     */
    public function setExploitant(\MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant $exploitant)
    {
        $this->exploitant = $exploitant;
        return $this;
    }

    /**
     * Get exploitant
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant
     */
    public function getExploitant()
    {
        return $this->exploitant;
    }
}
