<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\PersonnePhysique;

/**
 * Gerant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\GerantRepository")
 */
class Gerant extends PersonnePhysique
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
     *
     * @var type entreprise
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise", mappedBy="gerant")
     */
    private $entreprises;
    
        /**
     *
     * @var type string
     * 
     */
    protected $civilite;

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
     * Constructor
     */
    public function __construct()
    {
        $this->entreprises = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add entreprise
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise
     * @return Gerant
     */
    public function addEntreprises(\MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise)
    {
        $this->entreprises[] = $entreprise;

        return $this;
    }

    /**
     * Remove entreprise
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise
     */
    public function removeEntreprises(\MairieVoreppe\DemandeTravauxBundle\Entity\Entreprise $entreprise)
    {
        $this->entreprises->removeElement($entreprise);
    }

    /**
     * Get entreprise
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntreprise()
    {
        return $this->entreprises;
    }
}
