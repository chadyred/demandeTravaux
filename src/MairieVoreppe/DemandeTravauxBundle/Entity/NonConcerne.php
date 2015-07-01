<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\Reponse;
use JMS\Serializer\Annotation\Groups;

/**
 * NonConcerne
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\NonConcerneRepository")
 */
class NonConcerne extends Reponse
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
     * @var string
     *
     * @ORM\Column(name="distanceNC", type="decimal")
    * @Groups({"reponse_recepisse"})
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

    public function __toString()
    {
        return "Non concernée";
    }
}

