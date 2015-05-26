<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\PersonneMorale;
//On va mettre le namespace de notre méthode Classe interface Constraints de notre validator
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mairie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\MairieRepository")
 */
class Mairie extends PersonneMorale
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
     * @var \
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Periode", mappedBy="mairie", orphanRemoval=true, cascade={"persist", "remove"})
     */
    protected $periodes;
    
    /**
     * @var \
     * 
     * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Logo", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $logo;
    
    /**
     * @var users
     *
     * Si la mairie disparait ses services ne diparaiteront pas, il se peut qu'il y est des travaux réaliser par ces services. 
     * Lorsqu'un service a à son actif des travaux en gestion, ce dernier 
     *
     * @ORM\OneToMany(targetEntity="MairieVoreppe\UserBundle\Entity\Service", mappedBy="mairie", cascade={"persist"})
     */
     protected $services;

     //Permet de récupérer le maire en cours
     private $maireEnCours;
     
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->periodes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add periodes
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Periode $periodes
     * @return Mairie
     */
    public function addPeriode(\MairieVoreppe\DemandeTravauxBundle\Entity\Periode $periode)
    {
        $this->periodes[] = $periode;
        $periode->setMairie($this);

        return $this;
    }

    /**
     * Remove periodes
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Periode $periodes
     */
    public function removePeriode(\MairieVoreppe\DemandeTravauxBundle\Entity\Periode $periodes)
    {
        $this->periodes->removeElement($periodes);
    }

    /**
     * Get periodes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPeriodes()
    {
        return $this->periodes;
    }
  
    /**
     * Set logo
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Logo $logo
     * @return Mairie
     */
    public function setLogo(\MairieVoreppe\DemandeTravauxBundle\Entity\Logo $logo = null)
    {
        $this->logo = $logo;
        //DRY : on va associé notre entité avatar à l'utilisateur en cours
        $logo->setMairie($this);
    }

    /**
     * Get logo
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Logo 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Add service
     *
     * @param \MairieVoreppe\UserBundle\Entity\Service $service
     *
     * @return Mairie
     */
    public function addService(\MairieVoreppe\UserBundle\Entity\Service $service)
    {
        $this->services[] = $service;

        return $this;
    }

    /**
     * Remove service
     *
     * @param \MairieVoreppe\UserBundle\Entity\Service $service
     */
    public function removeService(\MairieVoreppe\UserBundle\Entity\Service $service)
    {
        $this->services->removeElement($service);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    public function getMaireEnCours()
    {
        $date = new \DateTime('now');
        $maire = new Maire();

        foreach($this->getPeriodes() as $periode)
        {
            if($periode->getDateDebut() >= $date && $periode->getDateFin())
                $maire = $periode->getMaire();
        }

        return $maire;
    }
}
