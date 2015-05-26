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
     * @var \$maire 
    * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Maire", inversedBy="periodes", cascade={"persist"})
     */
    private $maire;
    
     /**
     * @var \$mairie
      * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Mairie", inversedBy="periodes")
     */
    private $mairie;
    

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
     * Set maire
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Maire $maire
     * @return Periode
     */
    public function setMaire(\MairieVoreppe\DemandeTravauxBundle\Entity\Maire $maire)
    {
        $this->maire = $maire;
        
        return $this;
    }

    /**
     * Get maire
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Maire 
     */
    public function getMaire()
    {
        return $this->maire;
    }

    /**
     * Set mairie
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Mairie $mairie
     * @return Periode
     */
    public function setMairie(\MairieVoreppe\DemandeTravauxBundle\Entity\Mairie $mairie)
    {
        $this->mairie = $mairie;

        return $this;
    }

    /**
     * Get mairie
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Mairie 
     */
    public function getMairie()
    {
        return $this->mairie;
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
}
