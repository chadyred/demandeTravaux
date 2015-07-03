<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\RendezVous;
use JMS\Serializer\Annotation\Groups;

/**
 * InitiativeDeclarant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\InitiativeDeclarantRepository")
 */
class InitiativeDeclarant extends RendezVous
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
     * @ORM\Column(name="dateRetenue", type="date")     
     * @Groups({"rendezvous_recepisse"})
     */
    private $dateRetenue;


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
     * Set dateRetenue
     *
     * @param \DateTime $dateRetenue
     *
     * @return InitiativeDeclarant
     */
    public function setDateRetenue($dateRetenue)
    {
        $this->dateRetenue = $dateRetenue;

        return $this;
    }

    /**
     * Get dateRetenue
     *
     * @return \DateTime
     */
    public function getDateRetenue()
    {
        return $this->dateRetenue;
    }
}

