<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//On va hériter de notre classe User présent dans le bundle FOSUser. C'est la classe mère : on peut ainsi
//utiliser êt redefinir les élément de la classe mère.
//On va également override celle-ci afin de retirer des champs inutile lié au réseau sociaux
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="Application\Sonata\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
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
     * @var type string
     * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Civilite")
     */ 
     protected $civilite;
     
      /**
     * @var \Doctrine\Common\Collections\ArrayCollection() 
     * 
     * Un utilisateur peut avoir plusieurs travaux. Il sera en quelquesorte propriétaire du travaux créé. On pourra alors récupérer ses travaux.
     * Les travaux existeront toujours même après son départ. Le changement de personne sur un travaux se fera par l'administrateur seulement.
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Travaux", cascade={"persist"}, mappedBy="user")
     */
     protected $travaux;     
     
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
    * @var services
    *
    * Relation Many User to Many groups. Cette attribut est déjà présent mais on redéfinis son association ici. On ne met pas les accesseurs (add,remove, get)
    * car ils sont déjà présent dans notre classe parent.
    *
    * @ORM\ManyToMany(targetEntity="Application\Sonata\UserBundle\Entity\Service", inversedBy="users")
    */
    protected $services;

    
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add services
     *
     * @param \Application\Sonata\UserBundle\Entity\Service $services
     * @return User
     */
    public function addService(\Application\Sonata\UserBundle\Entity\Service $services)
    {
        $this->services[] = $services;

        return $this;
    }

    /**
     * Remove services
     *
     * @param \Application\Sonata\UserBundle\Entity\Service $services
     */
    public function removeService(\Application\Sonata\UserBundle\Entity\Service $services)
    {
        $this->services->removeElement($services);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getServices()
    {
        return $this->services;
    }
    
     /**
     * Set gerant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Civilite $civilite
     * @return Entreprise
     */
    public function setCivilite(\MairieVoreppe\DemandeTravauxBundle\Entity\Civilite $civilite = null)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get gerant
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Gerant 
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Add travaux
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Adresse $travaux
     *
     * @return User
     */
    public function addTravaux(\MairieVoreppe\DemandeTravauxBundle\Model\Travaux $travaux)
    {
        $this->travaux[] = $travaux;
        $travaux->setUser($this);

        return $this;
    }

    /**
     * Remove travaux
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Adresse $travaux
     */
    public function removeTravaux(\MairieVoreppe\DemandeTravauxBundle\Model\Travaux $travaux)
    {
        $this->travaux->removeElement($travaux);
    }

    /**
     * Get travaux
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTravaux()
    {
        return $this->travaux;
    }

    public function __toString()
    {
        if($this->getCivilite() != null)
            return $this->getCivilite()->getTitre() . " " . strtoupper($this->getFirstname()) . " " . $this->getLastname();
        else
            return strtoupper($this->getFirstname()) . " " . $this->getLastname();
    }
}


