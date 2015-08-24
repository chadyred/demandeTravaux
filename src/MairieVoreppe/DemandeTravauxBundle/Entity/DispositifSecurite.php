<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DispositifSecurite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecuriteRepository")
 */
class DispositifSecurite
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
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Recepisse", mappedBy="dispositifSecurite")
     */
    private $recepisses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recepisses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param string $description
     *
     * @return DispositifSecurite
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add recepiss
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $recepiss
     *
     * @return DispositifSecurite
     */
    public function addRecepiss(\MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $recepiss)
    {
        $this->recepisses[] = $recepiss;

        return $this;
    }

    /**
     * Remove recepiss
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $recepiss
     */
    public function removeRecepiss(\MairieVoreppe\DemandeTravauxBundle\Model\Recepisse $recepiss)
    {
        $this->recepisses->removeElement($recepiss);
    }

    /**
     * Get recepisses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecepisses()
    {
        return $this->recepisses;
    }
}
