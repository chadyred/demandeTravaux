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
     * Peut être null dans le cadre d'une suppression. En effet, lorsque l'on va supprimer une entreprise lié à une MOE (autrement dit à partir du côté inverse)
     * dans le cadre d'une one to one le orphanRemoval ne marche pas, et il en va de même pour le cascade={"remove"}, donc tout ce passe dans le controller
     *
     * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise", cascade={"persist", "remove"}, inversedBy="moePersonneMorale")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $entreprise;


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
     * On aura ainsi les deux side pour une OneTOOne où il est nécessaire d'avoir deux clés étrangères sans quoi DQL ne les gères pas
     * Peut être null dans le cadre d'une suppression. En effet, lorsque l'on va supprimer une entreprise lié à une MOE (autrement dit à partir du côté inverse)
     * dans le cadre d'une one to one le orphanRemoval ne marche pas, et il en va de même pour le cascade={"remove"}, donc tout ce passe dans le controller
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise
     * @return MOEPersonneMorale
     */
    public function setEntreprise(\MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        if($entreprise != null)
            $entreprise->setMoePersonneMorale($this);

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

   
}
