<?php

namespace MairieVoreppe\DemandeTravauxBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({ 
 * "moaPersonneMorale"="MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonneMorale", 
 * "moaPersonnePhysique"="MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonnePhysique",
 * "moePersonneMorale"="MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonneMorale", 
 * "moePersonnePhysique"="MairieVoreppe\DemandeTravauxBundle\Entity\MOEPersonnePhysique"
 *  })
 */
abstract class Declarant
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
