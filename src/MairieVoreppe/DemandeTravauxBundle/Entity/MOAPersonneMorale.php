<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\MaitreOuvrage;

/**
 * MOAPersonneMorale
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonneMoraleRepository")
 */
class MOAPersonneMorale extends MaitreOuvrage
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
     * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\PersonneMorale", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $personneMorale;  

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
     * Set personneMorale
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\PersonneMorale $personneMorale
     * @return MOAPersonneMorale
     */
    public function setPersonneMorale(\MairieVoreppe\DemandeTravauxBundle\Model\PersonneMorale $personneMorale = null)
    {
        $this->personneMorale = $personneMorale;

        return $this;
    }

    /**
     * Get personneMorale
     *
     * Spécialisation de la methode du super object dont le but est d'aiguillet selon la forme du polymorphisme par dérivation
     * que possède notre objet personne morale.
     * 
     * @return \MairieVoreppe\DemandeTravauxBundle\Model\PersonneMorale 
     */
    public function getPersonneMorale()
    {
        return $this->personneMorale;
    }
    
    public function __toString()
    {
        $toString = "";
        
        if($this->getPersonneMorale() instanceof Entreprise)
        {
            $toString = $this->getPersonneMorale()->getRaisonSociale() . ' ' . $this->getPersonneMorale()->getStatutJuridique()->getAbreviation();
        }
        else
        {
            $toString = $this->getPersonneMorale()->getRaisonSociale();
        }
        
        return $toString;
    }
}
