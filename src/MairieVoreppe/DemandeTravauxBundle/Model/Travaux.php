<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;
//On récupère l'entité DT ainsi tous ce qui est présent dans son parent ne doit pas adresse récupéré sauf 
//ceux que j'ai préciser dans l'entité DemandeTravaux qui possède l'annotation @Expose
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\DateFormatter\IntlDateFormatter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Travaux
 *
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({ 
 * "demandeTravaux"="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeTravaux",
 * "demandeIntentionCT"="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT",
 * "ATUrgent"="MairieVoreppe\DemandeTravauxBundle\Entity\ATUrgent"
 * })
 */
abstract class Travaux
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
     * @ORM\Column(name="numeroTeleservice", type="string", length=255, nullable=true)
     */
    protected $numeroTeleservice;


    
    /**
     * @var string
     *
     * @ORM\Column(name="numeroAffaireDeclarant", type="string", length=255, nullable=true)
     */
    protected $numeroAffaireDeclarant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebutTravaux", type="datetime", nullable=true)
     */
    protected $dateDebutTravaux;

    /**
     * @var \DateTime
     *
     */
    protected $dateFinTravaux;

    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    protected $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionTravaux", type="text", nullable=true)
     */
    protected $descriptionTravaux;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="noteComplementaire", type="text", nullable=true)
     */
    protected $noteComplementaire;
    
    
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection() 
     * 
     * Une personne n'a qu'une contactUrgent. Elle sera remplit et complétée lors de la création de celui-ci.
     * 
     * @ORM\ManyToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent", cascade={"persist", "remove"}, inversedBy="travaux")
     * @ORM\JoinColumn(nullable=true) 
     */
    protected $contactsUrgent; 
    
    /**
     * @var \DateTime
     *
     * La date est inscript sur l'enveloppe, le mail ou le fax
     *
     * @ORM\Column(name="dateReceptionDemande", type="datetime", nullable=false)
     */
    protected $dateReceptionDemande;
    
    /**
     * @var \DateTime
     *
     * Est null lorsque la réponse n'est pas encore émise
     *
     * @ORM\Column(name="dateReponseDemande", type="datetime", nullable=true)
     */
     protected $dateReponseDemande;
    
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection() 
     * 
     * Une personne n'a qu'une contactUrgent. Elle sera remplit et complétée lors de la création de celui-ci.
     * 
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\CanalReception", inversedBy="travaux")
     */
    protected $canalReception; 
    
     /**
     * @var \Doctrine\Common\Collections\ArrayCollection() 
     * 
     * Un chantier n'a qu'une adresse. Elle sera remplit et complétée lors de la création de celui-ci.
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Adresse", cascade={"persist", "remove"}, orphanRemoval=true, mappedBy="travaux")
     */
    protected $adresses;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection() 
     * 
     * Un travaux est créé par un user au sein d'un service, qui est celui pour lequel il est connecté. Ce choix se fait lors de la connexion.
     * 
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="travaux")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;
    
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection() 
     * 
     * Un travaux est créé par un user au sein d'un service, qui est celui pour lequel il est connecté. Ce choix se fait au sein d'une liste
     * 
     * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant", inversedBy="travaux")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $serviceExploitant;

    /**
    *
    * Permet de récupérer le toString de la date
    *
    */
    protected $dateDebut;
    
    public function __construct()
    {
        $this->contactsUrgent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numeroTeleservice
     *
     * @param string $numeroTeleservice
     * @return Travaux
     */
    public function setNumeroTeleservice($numeroTeleservice)
    {
        $this->numeroTeleservice = $numeroTeleservice;

        return $this;
    }

    /**
     * Get numeroTeleservice
     *
     * @return string 
     */
    public function getNumeroTeleservice()
    {
        return $this->numeroTeleservice;
    }

    /**
     * Set dateDebutTravaux
     *
     * @param \DateTime $dateDebutTravaux
     * @return Travaux
     */
    public function setDateDebutTravaux($dateDebutTravaux)
    {
        $this->dateDebutTravaux = $dateDebutTravaux;

        return $this;
    }

    /**
     * Get dateDebutTravaux
     *
     * @return \DateTime 
     */
    public function getDateDebutTravaux()
    {
        return $this->dateDebutTravaux;
    }

    /**
     * Get dateDebutTravaux
     *
     * @return \DateTime 
     */
    public function getDateFinTravaux()
    {   
         $this->dateFinTravaux = null;
         
        if($this->duree != "")
        {
              $this->dateFinTravaux = new \DateTime($this->dateDebutTravaux);
              // $this->dateFinTravaux = $this->dateDebutTravaux;
              $this->dateFinTravaux->add(new \DateInterval('P' . $this->duree . 'D'));    
        }

        return $this->dateFinTravaux;
        
    }


    /**
     * Set descriptionTravaux
     *
     * @param string $descriptionTravaux
     * @return Travaux
     */
    public function setDescriptionTravaux($descriptionTravaux)
    {
        $this->descriptionTravaux = $descriptionTravaux;

        return $this;
    }

    /**
     * Get descriptionTravaux
     *
     * @return string 
     */
    public function getDescriptionTravaux()
    {
        return $this->descriptionTravaux;
    }

    /**
     * Set noteComplementaire
     *
     * @param string $noteComplementaire
     * @return Travaux
     */
    public function setNoteComplementaire($noteComplementaire)
    {
        $this->noteComplementaire = $noteComplementaire;

        return $this;
    }
    
    
    /**
     * Set duree
     *
     * @param string $duree
     * @return Duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }
    
     /**
     * Get duree
     *
     * @return duree 
     */
    public function getDuree()
    {
        return $this->duree;
    }


    /**
     * Get noteComplementaire
     *
     * @return string 
     */
    public function getNoteComplementaire()
    {
        return $this->noteComplementaire;
    }
    
    /**
     * Set dateReceptionDemande
     *
     * @param \DateTime $dateReceptionDemande
     * @return Travaux2
     */
    public function setDateReceptionDemande($dateReceptionDemande)
    {
        $this->dateReceptionDemande = $dateReceptionDemande;

        return $this;
    }

    /**
     * Get dateReceptionDemande
     *
     * @return \DateTime 
     */
    public function getDateReceptionDemande()
    {
        return $this->dateReceptionDemande;
    }

    /**
     * Set dateReponseDemande
     *
     * @param \DateTime $dateReponseDemande
     * @return Travaux2
     */
    public function setDateReponseDemande($dateReponseDemande)
    {
        $this->dateReponseDemande = $dateReponseDemande;

        return $this;
    }

    /**
     * Get dateReponseDemande
     *
     * @return \DateTime 
     */
    public function getDateReponseDemande()
    {
        return $this->dateReponseDemande;
    }

    /**
     * Add contactsUrgent
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent $contactsUrgent
     * @return Travaux2
     */
    public function addContactsUrgent(\MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent $contactsUrgent)
    {
        $this->contactsUrgent[] = $contactsUrgent;

        return $this;
    }

    /**
     * Remove contactsUrgent
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent $contactsUrgent
     */
    public function removeContactsUrgent(\MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent $contactsUrgent)
    {
        $this->contactsUrgent->removeElement($contactsUrgent);
    }

    /**
     * Get contactsUrgent
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContactsUrgent()
    {
        return $this->contactsUrgent;
    }
    
    
    /**
     * Set canalReception
     *
     * @param string $canalReception
     * @return Travaux
     */
    public function setCanalReception(\MairieVoreppe\DemandeTravauxBundle\Entity\CanalReception $canalReception)
    {
        $this->canalReception = $canalReception;

        return $this;
    }
    
    
    /**
     * Get canalReception
     *
     * @return canalReception  
    */
    public function getCanalReception()
    {
        return $this->canalReception;
    }
    
   
    

    /**
     * Add adress
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Adresse $adress
     *
     * Un travaux peut être commencé et enregistré sans pour autant avoir d'adresse, tel un brouillon dans le workflow.
     *
     * @return Travaux2
     */
    public function addAdress(\MairieVoreppe\DemandeTravauxBundle\Entity\Adresse $adress = null)
    {
        if($adress != null){
            $this->adresses[] = $adress;
            $adress->setTravaux($this);
        }

        return $this;
    }

    /**
     * Remove adress
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Adresse $adress
     */
    public function removeAdress(\MairieVoreppe\DemandeTravauxBundle\Entity\Adresse $adress)
    {
        $this->adresses->removeElement($adress);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     *
     * @return Travaux2
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set service
     *
     * @param \Application\Sonata\UserBundle\Entity\Service $service
     *
     * @return Travaux2
     */
    public function setServiceExploitant(\MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant $serviceExploitant)
    {
        $this->serviceExploitant = $serviceExploitant;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Application\Sonata\UserBundle\Entity\Service
     */
    public function getServiceExploitant()
    {
        return $this->serviceExploitant;
    }

    /**
    * Un 'toString' pour la date de début des travaux nécessaire pour l'introspéction. On peut la transformer en français en deux ligne
    */
    public function getDateDebut()
    {
        setlocale (LC_TIME, 'fr_FR.utf8','fra');

        //Cette fonction est la seul à déterminer la langue. On récupère le timestamp de la date du début de chantier
        return strftime('%A %d %B %Y', $this->getDateDebutTravaux()->getTimestamp());
    }

    

    /**
     * Set numeroAffaireDeclarant
     *
     * @param string $numeroTeleservice
     * @return Travaux
     */
    public function setNumeroAffaireDeclarant($numeroAffaireDeclarant)
    {
        $this->numeroAffaireDeclarant = $numeroAffaireDeclarant;

        return $this;
    }

    /**
     * Get numeroAffaireDeclarant
     *
     * @return string
     */
    public function getNumeroAffaireDeclarant()
    {
        return $this->numeroAffaireDeclarant;
    }

}
