<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique;
use JMS\Serializer\Annotation\Groups;

/**
 * ContactUrgent
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\ContactUrgentRepository")
 */
class ContactUrgent extends PersonnePhysique
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
     * @ORM\ManyToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Travaux", cascade={"persist"}, mappedBy="contactsUrgent")
     */
    protected $travaux; 

    
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
     * Get travaux
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Model\Travaux 
     */
    public function getTravaux()
    {
        return $this->travaux;
    }

    /**
     * Add travaux
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Travaux $travaux
     * @return ContactUrgent
     */
    public function addTravaux(\MairieVoreppe\DemandeTravauxBundle\Model\Travaux $travaux)
    {
        $this->travaux[] = $travaux;

        return $this;
    }

    /**
     * Remove travaux
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Travaux $travaux
     */
    public function removeTravaux(\MairieVoreppe\DemandeTravauxBundle\Model\Travaux $travaux)
    {
        $this->travaux->removeElement($travaux);
    }
}
