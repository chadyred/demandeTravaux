<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

/**
 * PersonneMorale
 *
 * @ORM\Entity
 * 
 */
abstract class PersonneMorale extends Personne
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
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=255)
     */
    protected $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="raisonSociale", type="string", length=255)
     */
    protected $raisonSociale;

    /**
     * @var string
     *
     * @ORM\Column(name="complement", type="string", length=255, nullable=true)
     */
    protected $complement;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=255, nullable=true)
     */
    protected $service;

    /**
     * @var string
     * 
     * varchar de 35. Condition de validation de lingne fixe ou mobile pas encore à jour.
     *
     * @ORM\Column(name="telFax", type="phone_number", nullable=true)
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    protected $telFax;

    
    
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
     * Set siret
     *
     * @param string $siret
     * @return PersonneMorale
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string 
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set raisonSociale
     *
     * @param string $raisonSociale
     * @return PersonneMorale
     */
    public function setRaisonSociale($raisonSociale)
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    /**
     * Get raisonSociale
     *
     * @return string 
     */
    public function getRaisonSociale()
    {
        return $this->raisonSociale;
    }

    /**
     * Set complement
     *
     * @param string $complement
     * @return PersonneMorale
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Get complement
     *
     * @return string 
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set service
     *
     * @param string $service
     * @return PersonneMorale
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set telFax
     *
     * @param string $telFax
     * @return PersonneMorale
     */
    public function setTelFax($telFax)
    {
        $this->telFax = $telFax;

        return $this;
    }

    /**
     * Get telFax
     *
     * @return string 
     */
    public function getTelFax()
    {
        return $this->telFax;
    }

}
