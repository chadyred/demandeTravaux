<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\Personne;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use JMS\Serializer\Annotation\Groups;

/**
 * PersonnePhysique
 *
 * @ORM\Entity
 * })
 */
abstract class PersonnePhysique extends Personne
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
     * Le nom suffit
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Groups({"dt"})
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     * @Groups({"dt"})
     */
    protected $prenom;


    /**
     * @var string
     *
     * varchar de 35. Condition de validation de lingne fixe ou mobile pas encore à jour.
     * 
     * @ORM\Column(name="telMobile", type="phone_number", nullable=true)
     * @AssertPhoneNumber(defaultRegion="FR")
     * @Groups({"dt"})
     */
    protected $telMobile;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Groups({"dt"})
     */
    protected $email;
    
    /**
     *
     * @var type string
     * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Civilite", inversedBy="personnePhysique")
     * @Groups({"dt"})
     */ 
     protected $civilite;

    
    
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
     * Set nom
     *
     * @param string $nom
     * @return PersonnePhysique
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return PersonnePhysique
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }


    /**
     * Set telMobile
     *
     * @param string $telMobile
     * @return PersonnePhysique
     */
    public function setTelMobile($telMobile)
    {
        $this->telMobile = $telMobile;

        return $this;
    }

    /**
     * Get telMobile
     *
     * @return string 
     */
    public function getTelMobile()
    {
        return $this->telMobile;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return PersonnePhysique
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    
    /**
     * Set gerant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Civilite $civilite
     * @return Entreprise
     */
    public function setCivilite(\MairieVoreppe\DemandeTravauxBundle\Entity\Civilite $civilite = null)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get gerant
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Gerant 
     */
    public function getCivilite()
    {
        return $this->civilite;
    }
    
    //L'interface admin requiert que la visualisation depuis cette methode magique de la classe object ne soit pas vide
    public function __toString()
    {   
        if($this->getNom() != "")
            return $this->getCivilite()->getTitre() . ' ' . strtoupper($this->getNom()) . " " . $this->getPrenom();
        else 
            return "";
    }
}
