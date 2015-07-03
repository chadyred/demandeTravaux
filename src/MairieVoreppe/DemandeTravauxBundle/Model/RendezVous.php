<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * RendezVous
 *
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Model\RendezVousRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({ 
 * "initiativeDeclarant"="MairieVoreppe\DemandeTravauxBundle\Entity\InitiativeDeclarant", 
 * "communAccord"="MairieVoreppe\DemandeTravauxBundle\Entity\CommunAccord"
 *  })
 */
abstract class RendezVous
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
    * @Groups({"rendezvous_recepisse"})
    */
    protected $class;


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
     * Get categorieReseauOuvrage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

   
}
