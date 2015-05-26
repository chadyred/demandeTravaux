<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recepisse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseRepository")
 */
class Recepisse
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
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="extensionPrevue", type="text")
     */
    private $extensionPrevue;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modificationEnCours", type="boolean")
     */
    private $modificationEnCours;

    /**
     * @var string
     *
     * @ORM\Column(name="nomRepresentant", type="string", length=255)
     */
    private $nomRepresentant;

    /**
     * @var string
     *
     * @ORM\Column(name="telephoneRepresentant", type="string", length=255)
     */
    private $telephoneRepresentant;

    /**
     * @var boolean
     *
     * @ORM\Column(name="planJoint", type="boolean")
     */
    private $planJoint;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prendreEnCompteServitude", type="boolean")
     */
    private $prendreEnCompteServitude;

    /**
     * @var boolean
     *
     * @ORM\Column(name="branchementRattache", type="boolean")
     */
    private $branchementRattache;

    /**
     * @var string
     *
     * @ORM\Column(name="recommandationSecurite", type="text")
     */
    private $recommandationSecurite;

    /**
     * @var string
     *
     * @ORM\Column(name="rubriqueGuideTechSecurite", type="text")
     */
    private $rubriqueGuideTechSecurite;

    /**
     * @var string
     *
     * @ORM\Column(name="mesureSecurite", type="text")
     */
    private $mesureSecurite;

    /**
     * @var string
     *
     * @ORM\Column(name="telServiceDegradation", type="string", length=255)
     */
    private $telServiceDegradation;

    /**
     * @var string
     *
     * @ORM\Column(name="serviceDepartementIncendieSecours", type="string", length=255)
     */
    private $serviceDepartementIncendieSecours;

    /**
     * @var string
     *
     * @ORM\Column(name="telServiceDepartementIncendieSecours", type="string", length=255)
     */
    private $telServiceDepartementIncendieSecours;

    /**
     * @var string
     *
     * @ORM\Column(name="responsableDossier", type="string", length=255)
     */
    private $responsableDossier;

    /**
     * @var string
     *
     * @ORM\Column(name="telResponsableDossier", type="string", length=255)
     */
    private $telResponsableDossier;


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
}

