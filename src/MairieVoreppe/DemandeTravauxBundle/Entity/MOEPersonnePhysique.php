<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\MaitreOeuvre;

/**
 * MOAPersonnePhysique
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonnePhysiqueRepository")
 */
class MOEPersonnePhysique extends MaitreOeuvre
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
     * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Civil", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $civil;    
    
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
     * Set civil
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Civil $civil
     * @return MOEPersonnePhysique
     */
    public function setCivil(\MairieVoreppe\DemandeTravauxBundle\Entity\Civil $civil = null)
    {
        $this->civil = $civil;

        return $this;
    }

    /**
     * Get civil
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Civil 
     */
    public function getCivil()
    {
        return $this->civil;
    }
    
    public function __toString()
    {
        return $this->getCivil()->__toString();
    }
}
