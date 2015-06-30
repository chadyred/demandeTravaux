<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\ReponseRepository")
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

   
}

