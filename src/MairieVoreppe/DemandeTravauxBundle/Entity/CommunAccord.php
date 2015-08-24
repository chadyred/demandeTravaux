<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\RendezVous;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CommunAccord
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\CommunAccordRepository")
 */
class CommunAccord extends RendezVous
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
     * @ORM\Column(name="dateRetenue", type="datetime") 
     * @Assert\NotBlank()
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
     * @return CommunAccord
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

