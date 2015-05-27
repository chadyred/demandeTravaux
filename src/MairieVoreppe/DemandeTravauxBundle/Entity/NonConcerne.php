<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NonConcerne
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\NonConcerneRepository")
 */
class NonConcerne
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
     * @ORM\Column(name="distanceNC", type="decimal")
     */
    private $distanceNC;


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
     * Set distanceNC
     *
     * @param string $distanceNC
     *
     * @return NonConcerne
     */
    public function setDistanceNC($distanceNC)
    {
        $this->distanceNC = $distanceNC;

        return $this;
    }

    /**
     * Get distanceNC
     *
     * @return string
     */
    public function getDistanceNC()
    {
        return $this->distanceNC;
    }
}

