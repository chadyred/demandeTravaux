<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use JMS\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Model\RecepisseRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({ 
 * "recepisseDt"="MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDT", 
 * "recepisseDict"="MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICT"
 *  })
 */
abstract class Recepisse
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    protected $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="extensionPrevue", type="text")
     */
    protected $extensionPrevue;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modificationEnCours", type="boolean")
     */
    protected $modificationEnCours;


    /**
     * @var boolean
     *
     * Permet de voir rapidement si le chantier est sensible ou non
     *
     * @ORM\Column(name="chantierSensible", type="boolean")
     */
    protected $chantierSensible;


    /**
     * @var string
     *
     * @ORM\Column(name="nomRepresentant", type="string", length=255)
     */
    protected $nomRepresentant;


    /**
     * @var boolean
     *
     * Permet de valider la prise de rendez-vous (un rendez-vous est facultatif si décoché les rendez vous ne sont pas prise en compte à vérifier dans le controller)
     *
     * @ORM\Column(name="priseRendezVous", type="boolean")
     */
    protected $priseRendezVous;

    /**
     * @var string
     *
     * @ORM\Column(name="telephoneRepresentant", type="phone_number", length=255)
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    protected $telephoneRepresentant;

    /**
     * @var boolean
     *
     * @ORM\Column(name="planJoint", type="boolean")
     */
    protected $planJoint;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prendreEnCompteServitude", type="boolean")
     */
    protected $prendreEnCompteServitude;

    /**
     * @var boolean
     *
     * @ORM\Column(name="branchementRattache", type="boolean")
     */
    protected $branchementRattache;

    /**
     * @var string
     *
     * @ORM\Column(name="recommandationSecurite", type="text")
     */
    protected $recommandationSecurite;

    /**
     * @var string
     *
     * @ORM\Column(name="rubriqueGuideTechSecurite", type="text")
     */
    protected $rubriqueGuideTechSecurite;

    /**
     * @var string
     *
     * @ORM\Column(name="mesureSecurite", type="text")
     */
    protected $mesureSecurite;

    /**
     * @var string
     *
     * @ORM\Column(name="telServiceDegradation", type="phone_number", length=255)
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    protected $telServiceDegradation;

    /**
     * @var string
     *
     * @ORM\Column(name="serviceDepartementIncendieSecours", type="string", length=255)
     */
    protected $serviceDepartementIncendieSecours;

    /**
     * @var string
     *
     * @ORM\Column(name="telServiceDepartementIncendieSecours", type="phone_number", length=255)
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    protected $telServiceDepartementIncendieSecours;

    /**
     * @var string
     *
     * @ORM\Column(name="responsableDossier", type="string", length=255)
     */
    protected $responsableDossier;

    /**
     * @var string
     *
     * @ORM\Column(name="telResponsableDossier", type="phone_number", length=255)
     * @AssertPhoneNumber(defaultRegion="FR")
     */
    protected $telResponsableDossier;

   /**
    * reponse
    *
    * Peut être null si le recepisse est en cours de création ( penser à un système de brouillon)
    *
    * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Reponse", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    * @Groups({"reponse_recepisse"})
    */    
    protected $reponse;


   /**
    * RecepisseDICT
    *
    * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\RendezVous", cascade={"persist"})
    *
    */
    protected $rendezVous;

   /**
    * Recepisse
    *
    * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\EmplacementReseauOuvrage", mappedBy="recepisse", cascade={"persist", "remove"})
    * @ORM\JoinColumn(nullable=false)
    */
    protected $emplacementsReseauOuvrage;


   /**
    * Recepisse
    *
    * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\MiseHorsTension", inversedBy="recepisses")
    */
    protected $miseHorsTension;


    /**
    * Doctrine Array
    *
    * Liste des catégorie réseau concernée de l'exploitant Mairie
    *
    * @ORM\ManyToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecurite", inversedBy="recepisses")
    */
    private $dispositifsSecurite;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->emplacementsReseauOuvrage = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateCreation = new \DateTime('now');
        
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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Recepisse
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set extensionPrevue
     *
     * @param string $extensionPrevue
     *
     * @return Recepisse
     */
    public function setExtensionPrevue($extensionPrevue)
    {
        $this->extensionPrevue = $extensionPrevue;

        return $this;
    }

    /**
     * Get extensionPrevue
     *
     * @return string
     */
    public function getExtensionPrevue()
    {
        return $this->extensionPrevue;
    }

    /**
     * Set modificationEnCours
     *
     * @param boolean $modificationEnCours
     *
     * @return Recepisse
     */
    public function setModificationEnCours($modificationEnCours)
    {
        $this->modificationEnCours = $modificationEnCours;

        return $this;
    }

    /**
     * Get modificationEnCours
     *
     * @return boolean
     */
    public function getModificationEnCours()
    {
        return $this->modificationEnCours;
    }

     /**
     * Set priseRendezVous
     *
     * @param boolean $priseRendezVous
     *
     * @return Recepisse
     */
    public function setPriseRendezVous($priseRendezVous)
    {
        $this->priseRendezVous = $priseRendezVous;

        return $this;
    }

    /**
     * Get priseRendezVous
     *
     * @return boolean
     */
    public function getPriseRendezVous()
    {
        return $this->priseRendezVous;
    }


    /**
     * Set chantierSensible
     *
     * @param boolean $chantierSensible
     *
     * @return Recepisse
     */
    public function setChantierSensible($chantierSensible)
    {
        $this->chantierSensible = $chantierSensible;

        return $this;
    }

    /**
     * Get chantierSensible
     *
     * @return boolean
     */
    public function getChantierSensible()
    {
        return $this->chantierSensible;
    }

    /**
     * Set nomRepresentant
     *
     * @param string $nomRepresentant
     *
     * @return Recepisse
     */
    public function setNomRepresentant($nomRepresentant)
    {
        $this->nomRepresentant = $nomRepresentant;

        return $this;
    }

    /**
     * Get nomRepresentant
     *
     * @return string
     */
    public function getNomRepresentant()
    {
        return $this->nomRepresentant;
    }

    /**
     * Set telephoneRepresentant
     *
     * @param string $telephoneRepresentant
     *
     * @return Recepisse
     */
    public function setTelephoneRepresentant($telephoneRepresentant)
    {
        $this->telephoneRepresentant = $telephoneRepresentant;

        return $this;
    }

    /**
     * Get telephoneRepresentant
     *
     * @return string
     */
    public function getTelephoneRepresentant()
    {
        return $this->telephoneRepresentant;
    }

    /**
     * Set planJoint
     *
     * @param boolean $planJoint
     *
     * @return Recepisse
     */
    public function setPlanJoint($planJoint)
    {
        $this->planJoint = $planJoint;

        return $this;
    }

    /**
     * Get planJoint
     *
     * @return boolean
     */
    public function getPlanJoint()
    {
        return $this->planJoint;
    }

    /**
     * Set prendreEnCompteServitude
     *
     * @param boolean $prendreEnCompteServitude
     *
     * @return Recepisse
     */
    public function setPrendreEnCompteServitude($prendreEnCompteServitude)
    {
        $this->prendreEnCompteServitude = $prendreEnCompteServitude;

        return $this;
    }

    /**
     * Get prendreEnCompteServitude
     *
     * @return boolean
     */
    public function getPrendreEnCompteServitude()
    {
        return $this->prendreEnCompteServitude;
    }

    /**
     * Set branchementRattache
     *
     * @param boolean $branchementRattache
     *
     * @return Recepisse
     */
    public function setBranchementRattache($branchementRattache)
    {
        $this->branchementRattache = $branchementRattache;

        return $this;
    }

    /**
     * Get branchementRattache
     *
     * @return boolean
     */
    public function getBranchementRattache()
    {
        return $this->branchementRattache;
    }

    /**
     * Set recommandationSecurite
     *
     * @param string $recommandationSecurite
     *
     * @return Recepisse
     */
    public function setRecommandationSecurite($recommandationSecurite)
    {
        $this->recommandationSecurite = $recommandationSecurite;

        return $this;
    }

    /**
     * Get recommandationSecurite
     *
     * @return string
     */
    public function getRecommandationSecurite()
    {
        return $this->recommandationSecurite;
    }

    /**
     * Set rubriqueGuideTechSecurite
     *
     * @param string $rubriqueGuideTechSecurite
     *
     * @return Recepisse
     */
    public function setRubriqueGuideTechSecurite($rubriqueGuideTechSecurite)
    {
        $this->rubriqueGuideTechSecurite = $rubriqueGuideTechSecurite;

        return $this;
    }

    /**
     * Get rubriqueGuideTechSecurite
     *
     * @return string
     */
    public function getRubriqueGuideTechSecurite()
    {
        return $this->rubriqueGuideTechSecurite;
    }

    /**
     * Set mesureSecurite
     *
     * @param string $mesureSecurite
     *
     * @return Recepisse
     */
    public function setMesureSecurite($mesureSecurite)
    {
        $this->mesureSecurite = $mesureSecurite;

        return $this;
    }

    /**
     * Get mesureSecurite
     *
     * @return string
     */
    public function getMesureSecurite()
    {
        return $this->mesureSecurite;
    }

    /**
     * Set telServiceDegradation
     *
     * @param string $telServiceDegradation
     *
     * @return Recepisse
     */
    public function setTelServiceDegradation($telServiceDegradation)
    {
        $this->telServiceDegradation = $telServiceDegradation;

        return $this;
    }

    /**
     * Get telServiceDegradation
     *
     * @return string
     */
    public function getTelServiceDegradation()
    {
        return $this->telServiceDegradation;
    }

    /**
     * Set serviceDepartementIncendieSecours
     *
     * @param string $serviceDepartementIncendieSecours
     *
     * @return Recepisse
     */
    public function setServiceDepartementIncendieSecours($serviceDepartementIncendieSecours)
    {
        $this->serviceDepartementIncendieSecours = $serviceDepartementIncendieSecours;

        return $this;
    }

    /**
     * Get serviceDepartementIncendieSecours
     *
     * @return string
     */
    public function getServiceDepartementIncendieSecours()
    {
        return $this->serviceDepartementIncendieSecours;
    }

    /**
     * Set telServiceDepartementIncendieSecours
     *
     * @param string $telServiceDepartementIncendieSecours
     *
     * @return Recepisse
     */
    public function setTelServiceDepartementIncendieSecours($telServiceDepartementIncendieSecours)
    {
        $this->telServiceDepartementIncendieSecours = $telServiceDepartementIncendieSecours;

        return $this;
    }

    /**
     * Get telServiceDepartementIncendieSecours
     *
     * @return string
     */
    public function getTelServiceDepartementIncendieSecours()
    {
        return $this->telServiceDepartementIncendieSecours;
    }

    /**
     * Set responsableDossier
     *
     * @param string $responsableDossier
     *
     * @return Recepisse
     */
    public function setResponsableDossier($responsableDossier)
    {
        $this->responsableDossier = $responsableDossier;

        return $this;
    }

    /**
     * Get responsableDossier
     *
     * @return string
     */
    public function getResponsableDossier()
    {
        return $this->responsableDossier;
    }

    /**
     * Set telResponsableDossier
     *
     * @param string $telResponsableDossier
     *
     * @return Recepisse
     */
    public function setTelResponsableDossier($telResponsableDossier)
    {
        $this->telResponsableDossier = $telResponsableDossier;

        return $this;
    }

    /**
     * Get telResponsableDossier
     *
     * @return string
     */
    public function getTelResponsableDossier()
    {
        return $this->telResponsableDossier;
    }

    /**
     * Set reponse
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Reponse $reponse
     *
     * @return Recepisse
     */
    public function setReponse(array $types = null, \MairieVoreppe\DemandeTravauxBundle\Model\Reponse $reponse = null)
    {
        $this->reponse = $types[0];

        return $this;
    }

    /**
     * Get reponse
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Model\Reponse
     */
    public function getReponse()
    {
        return array($this->reponse);
    }

    /**
     * Add emplacementsReseauOuvrage
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\EmplacementReseauOuvrage $emplacementReseauOuvrage
     *
     * @return Recepisse
     */
    public function addEmplacementsReseauOuvrage(\MairieVoreppe\DemandeTravauxBundle\Entity\EmplacementReseauOuvrage $emplacementReseauOuvrage)
    {
        $this->emplacementsReseauOuvrage[] = $emplacementReseauOuvrage;
        $emplacementReseauOuvrage->setRecepisse($this);

        return $this;
    }

    /**
     * Remove emplacementsReseauOuvrage
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\EmplacementReseauOuvrage $emplacementReseauOuvrage
     */
    public function removeEmplacementsReseauOuvrage(\MairieVoreppe\DemandeTravauxBundle\Entity\EmplacementReseauOuvrage $emplacementReseauOuvrage)
    {
        $this->emplacementsReseauOuvrage->removeElement($emplacementReseauOuvrage);
    }

    /**
     * Get emplacementsReseauOuvrage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmplacementsReseauOuvrage()
    {
        return $this->emplacementsReseauOuvrage;
    }

    /**
     * Set rendezVous
     *
     * On a un tableau car le bundle Infinite retourne un tableau, puisqu'il ne gère pas les OneToOne. En effet, on pourrait avoir 50 reponse or nous ils 
     * nous en faut qu'une.
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\RendezVous $rendezVous
     *
     * @return Recepisse
     */
    public function setRendezVous(array $rendezVous = null)
    {
        $this->rendezVous = $rendezVous[0];

        return $this;
    }

    /**
     * Get rendezVous
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\RendezVous
     */
    public function getRendezVous()
    {
        return array($this->rendezVous);
    }

    /**
     * Set miseHorsTension
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\EmplacementReseauOuvrage $miseHorsTension
     *
     * @return Recepisse
     */
    public function setMiseHorsTension(\MairieVoreppe\DemandeTravauxBundle\Entity\MiseHorsTension $miseHorsTension = null)
    {
        $this->miseHorsTension = $miseHorsTension;
        $miseHorsTension->addRecepiss($this);

        return $this;
    }

    /**
     * Get miseHorsTension
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\EmplacementReseauOuvrage
     */
    public function getMiseHorsTension()
    {
        return $this->miseHorsTension;
    }

    /**
     * Add dispositifsSecurite
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecurite $dispositifsSecurite
     *
     * @return Recepisse
     */
    public function addDispositifsSecurite(\MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecurite $dispositifsSecurite)
    {
        $this->dispositifsSecurite[] = $dispositifsSecurite;
        $dispositifsSecurite->addRecepiss($this);

        return $this;
    }

    /**
     * Remove dispositifsSecurite
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecurite $dispositifsSecurite
     */
    public function removeDispositifsSecurite(\MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecurite $dispositifsSecurite)
    {
        $this->dispositifsSecurite->removeElement($dispositifsSecurite);
    }

    /**
     * Get dispositifsSecurite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDispositifsSecurite()
    {
        return $this->dispositifsSecurite;
    }
}
