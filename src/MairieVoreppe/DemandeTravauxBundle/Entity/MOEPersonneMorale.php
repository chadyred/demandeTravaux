<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\MaitreOeuvre;

/**
 * MOAPersonneMorale
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMoraleRepository")
 */
class MOEPersonneMorale extends MaitreOeuvre
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
     * Une personne n'a qu'une contactUrgent. Elle sera remplit et complétée lors de la création de celui-ci.
     * 
     * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise", cascade={"persist", "remove"})
     */
    protected $entreprise;    

    /**
    * @var boolean
    *
    *
    * @ORM\column(name="prestataire_dict", type="boolean", nullable=false)
    *
    */
    private $prestataireDICT;

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
     * Set entreprise
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise
     * @return MOEPersonneMorale
     */
    public function setEntreprise(\MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise 
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }
    
    /**
     * Un maitre d'oeuvre en tant que personne morale ne peut être qu'une entreprise
     * 
     * @return string
     */
    public function __toString()
    {
        $toString = "";
        $toString = $this->getEntreprise()->getRaisonSociale() . ' ' . $this->getEntreprise()->getStatutJuridique()->getAbreviation();
        
        
        return $toString;
    }

    /**
     * Set prestataireDICT
     *
     * @param boolean $prestataireDICT
     *
     * @return MOEPersonneMorale
     */
    public function setPrestataireDICT($prestataireDICT)
    {
        $this->prestataireDICT = $prestataireDICT;

        return $this;
    }

    /**
     * Get prestataireDICT
     *
     * @return boolean
     */
    public function getPrestataireDICT()
    {
        return $this->prestataireDICT;
    }
}
