<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({ 
 * "entreprise"="MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise", 
 * "mairie"="MairieVoreppe\DemandeTravauxBundle\Entity\Mairie",
 * "civil"="MairieVoreppe\DemandeTravauxBundle\Entity\Civil", 
 * "gerant"="MairieVoreppe\DemandeTravauxBundle\Entity\Gerant", 
 * "maire"="MairieVoreppe\DemandeTravauxBundle\Entity\Maire",
 * "contact_urgent"="MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent"
 *  })
 */
abstract class Personne
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
     * @var \Doctrine\Common\Collections\ArrayCollection() 
     * 
     * Une personne n'a qu'une adresse. Elle sera remplit et complétée lors de la création de celui-ci.
     * 
     * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Adresse", cascade={"persist", "remove"}, inversedBy="personne")
     */
    protected $adresse;    
    
    
    /**
     * @var string
     *
     * varchar de 35. Condition de validation de ligne fixe ou mobile pas encore à jour.
     * 
     * @ORM\Column(name="telFixe", type="phone_number", nullable=true)
     * @AssertPhoneNumber(defaultRegion="FR")
     * @Groups({"dt"})
     */
    protected $telFixe;

       
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
     * Add adresse
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Adresse $adresse
     * @return Gerant
     */
    public function setAdresse(\MairieVoreppe\DemandeTravauxBundle\Entity\Adresse $adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }
    /**
     * Get adresse
     *
     * @return Adresse 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
    
    
    /**
     * Set telFixe
     *
     * @param string $telFixe
     * @return PersonnePhysique
     */
    public function setTelFixe($telFixe)
    {
        $this->telFixe = $telFixe;

        return $this;
    }

    /**
     * Get telFixe
     *
     * @return string 
     */
    public function getTelFixe()
    {
        return $this->telFixe;
    }

}
