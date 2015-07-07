<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Civilite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\CiviliteRepository")
 */
class Civilite
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     * @Groups({"dt"})
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviation", type="string", length=255)
     * @Groups({"dt"})
     */
    private $abreviation;
    
    /**
     *
     * @var type string
     * 
     * On peut mapper vers un autre dossier que celui de entity grâce à une config custome du doctrine ORM (testé si on a bien tout les personne physique par civilité
     * si cela ne fonctionne pas il sera nécessaire d'effectuer pour chaque polymorphe de dérivation ce type de récupération)
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique", mappedBy="civilite")
     */
    protected $personnePhysique;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personnePhysique = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set titre
     *
     * @param string $titre
     * @return Civilite
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set abreviation
     *
     * @param string $abreviation
     * @return Civilite
     */
    public function setAbreviation($abreviation)
    {
        $this->abreviation = $abreviation;

        return $this;
    }

    /**
     * Get abreviation
     *
     * @return string 
     */
    public function getAbreviation()
    {
        return $this->abreviation;
    }

    /**
     * Add personnePhysique
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique $personnePhysique
     * @return Civilite
     */
    public function addPersonnePhysique(\MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique $personnePhysique)
    {
        $this->personnePhysique[] = $personnePhysique;

        return $this;
    }

    /**
     * Remove personnePhysique
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique $personnePhysique
     */
    public function removePersonnePhysique(\MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique $personnePhysique)
    {
        $this->personnePhysique->removeElement($personnePhysique);
    }

    /**
     * Get personnePhysique
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersonnePhysique()
    {
        return $this->personnePhysique;
    }    
}