<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Adresse
 *
 * Autocompletion réalisée avec Google Places
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\AdresseRepository")
 */
class Adresse
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
     * Le numéro de rue n'est pas obliguatoire par qu'un travaux peut avoir lieu sur la même rue
     * 
     * @ORM\Column(name="numeroRue", type="string", length=255, nullable=true)
     * @Groups({"dt"})
     */
    private $numeroRue;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Groups({"dt"})
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="complementAdresse", type="string", length=255, nullable=true)
     * @Groups({"dt"})
     */
    private $complementAdresse;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuDit", type="string", length=255, nullable=true)
     * @Groups({"dt"})
     */
    private $lieuDit;

       
    
    /**
     * @var type Travaux
     * 
     * Lorsque l'on supprime un travaux les adresses doivent être supprimé en cascade ceci est nécessaire avec les class abstraite, en l'occurance Travaux.
     * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Travaux", inversedBy="adresses")
     * @ORM\JoinColumn(name="travaux_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $travaux;
    
    
    /**
     * @var type Ville
     * 
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     * @Groups({"dt"})
     */
    private $ville;

    /**
     * @var type Ville
     *
     * @ORM\Column(name="cp", type="string", length=255, nullable=true)
     * @Groups({"dt"})
     */
    private $cp;

    //Permet de récupérer l'adresse complète. Utilie pour l'introspection pour le publipostage
    //des modèles d'arrêtés
    private $adresseComplete;

    /**
     * @var type Ville
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=true)
     * @Groups({"dt"})
     */
    private $pays; 
    
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
     * Set numeroRue
     *
     * @param string $numeroRue
     * @return Adresse
     */
    public function setNumeroRue($numeroRue)
    {
        $this->numeroRue = $numeroRue;

        return $this;
    }

    /**
     * Get numeroRue
     *
     * @return string 
     */
    public function getNumeroRue()
    {
        return $this->numeroRue;
    }


    /**
     * Set complementAdresse
     *
     * @param string $complementAdresse
     * @return Adresse
     */
    public function setComplementAdresse($complementAdresse)
    {
        $this->complementAdresse = $complementAdresse;

        return $this;
    }

    /**
     * Get complementAdresse
     *
     * @return string 
     */
    public function getComplementAdresse()
    {
        return $this->complementAdresse;
    }

    /**
     * Set lieuDit
     *
     * @param string $lieuDit
     * @return Adresse
     */
    public function setLieuDit($lieuDit)
    {
        $this->lieuDit = $lieuDit;

        return $this;
    }

    /**
     * Get lieuDit
     *
     * @return string 
     */
    public function getLieuDit()
    {
        return $this->lieuDit;
    }

    

    /**
     * Set ville
     *
     * @param  $ville
     * @return Adresse
     */
    public function setVille($ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Model\Personne 
     */
    public function getVille()
    {
        return $this->ville;
    }
    
    public function getNumRueAdresse()
    {
        return $this->getNumeroRue() . ", " . $this->getAdresse() . " " . $this->getComplementAdresse();
    }

    
    
    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
    
       /**
     * Set travaux
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Travaux $travaux
     * @return Adresse
     */
    public function setTravaux(\MairieVoreppe\DemandeTravauxBundle\Model\Travaux $travaux)
    {
        $this->travaux = $travaux;

        return $this;
    }

    /**
     * Get travaux
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Model\Travaux 
     */
    public function getTravaux()
    {
        return $this->travaux;
    }

    /**
     * Set cp
     *
     * @param string $cp
     *
     * @return Adresse
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }


    
    //Méthode personnalisé
    public function getAdresseCompleteAvecLieuDit()
    {
        $adresseComplete = "";
        $adresseComplete .= $this->getNumeroRue();
        $this->getLieuDit() != "" ? ($adresseComplete .=  ', ' . $this->getLieuDit()) : ($adresseComplete .=  ', ' . $this->getAdresse() . ' ' . $this->getComplementAdresse() . ' ');
        $adresseComplete .= $this->getCp() . ' ' . $this->getVille();
                
        return $adresseComplete;       
    }

     //Méthode personnalisé
    public function getAdresseCompleteSansLieuDit()
    {
        $adresseComplete = "";
        $adresseComplete .= $this->getNumeroRue();
        $adresseComplete .=  ', ' . $this->getAdresse() . ' ' . $this->getComplementAdresse() . ' ';
        $adresseComplete .= $this->getCp() . ' ' . $this->getVille();
                 
    }


     //Méthode personnalisé
    public function getAdresseCompleteNumRueAdresse()
    {
         $adresseComplete = "";
        $adresseComplete .= $this->getNumeroRue();
        $adresseComplete .=  ', ' . $this->getAdresse() . ' ' . $this->getComplementAdresse();


        return $adresseComplete;      
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Adresse
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }
}
