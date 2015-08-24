<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CanalReception
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\CanalReceptionRepository")
 */
class CanalReception
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
     * @ORM\Column(name="libelle", type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"dt"})
     */
    private $libelle;
    
    
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection() 
     * 
     * Une personne n'a qu'une contactUrgent. Elle sera remplit et complétée lors de la création de celui-ci.
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Travaux", mappedBy="canalReception")
     */
    private $travaux;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->travaux = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set libelle
     *
     * @param string $libelle
     * @return CanalReception
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Add travaux
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent $travaux
     * @return CanalReception
     */
    public function addTravaux(\MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent $travaux)
    {
        $this->travaux[] = $travaux;

        return $this;
    }

    /**
     * Remove travaux
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent $travaux
     */
    public function removeTravaux(\MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgent $travaux)
    {
        $this->travaux->removeElement($travaux);
    }

    /**
     * Get travaux
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTravaux()
    {
        return $this->travaux;
    }
}
