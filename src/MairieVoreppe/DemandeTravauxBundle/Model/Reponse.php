<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Groups;

/**
 * Reponse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Model\ReponseRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({ 
 * "concerne"="MairieVoreppe\DemandeTravauxBundle\Entity\Concerne", 
 * "nonConcerne"="MairieVoreppe\DemandeTravauxBundle\Entity\NonConcerne",
 * "demandeImprecise"="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeImprecise"
 *  })
 */
abstract class Reponse
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
    * @Groups({"reponse_recepisse"})
    * Attribut qui permet de déterminer le type pour la polycollection gérer en javascript
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

