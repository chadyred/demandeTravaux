<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique;

/**
 * Civil
 * @ORM\Table(name="civil")
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\CivilRepository")
 *
 */
class Civil extends PersonnePhysique
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
