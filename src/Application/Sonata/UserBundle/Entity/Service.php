<?php
    namespace Application\Sonata\UserBundle\Entity;
     
    use FOS\UserBundle\Entity\Group as BaseGroup;
    use Doctrine\ORM\Mapping as ORM;
     
    /**
     * @ORM\Entity(repositoryClass="Application\Sonata\UserBundle\Entity\ServiceRepository")
     * @ORM\Table(name="service")
     */
    class Service extends BaseGroup
    {
     
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
         protected $id; 
        

        /**
        * @var users
        *
        * Tableau de type DoctrineArray() qui contient les utilisateur du groupe
        *
        * @ORM\ManyToMany(targetEntity="Application\Sonata\UserBundle\Entity\User", mappedBy="services", cascade={"persist"})
        */
        protected $users; 
        
        
        /**
        * @var users
        *
        * Tableau de type DoctrineArray() qui contient les utilisateur du groupe. Le service du travaux est ajouter au sein du controller, grâce à la session sous laquel
        * il est connecté. 
        *
        * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Model\Travaux", mappedBy="service")
        */
        protected $travaux;
        
        /**
        * @var users
        *
        * Tableau de type DoctrineArray() qui contient les utilisateur du groupe. Le service du travaux est ajouter au sein du controller, grâce à la session sous laquel
        * il est connecté. 
        *
        * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant", mappedBy="service")
        */
        protected $servicesExploitant;
        
        public function __construct($name, $roles = array())
        {
            //Une classe à pour instrctruction dans sont constructeur, le constructeur du parent
            parent::__construct($name, $roles = array());
            $this->users = new \Doctrine\Common\Collections\ArrayCollection();
            $this->travaux = new \Doctrine\Common\Collections\ArrayCollection();
            $this->servicesExploitant = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add user.
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     *
     * @return Group
     */
    public function addUser(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;
        $user->addGroup($this);

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     */
    public function removeUser(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
    

    /**
     * Add travaux
     *
     * @param \Application\Sonata\UserBundle\Entity\User $travaux
     *
     * @return Service
     */
    public function addTravaux(\Application\Sonata\UserBundle\Entity\User $travaux)
    {
        $this->travaux[] = $travaux;

        return $this;
    }

    /**
     * Remove travaux
     *
     * @param \Application\Sonata\UserBundle\Entity\User $travaux
     */
    public function removeTravaux(\Application\Sonata\UserBundle\Entity\User $travaux)
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
        return $this->getName();
    }

    

    /**
     * Set responsableExploitant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant $serviceExploitant
     *
     * @return Service
     */
    public function addServicesExploitant(\MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant $serviceExploitant = null)
    {
        $this->responsablesExploitant[] = $serviceExploitant;

        return $this;
    }

    /**
     * Set responsableExploitant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant $serviceExploitant
     *
     * @return Service
     */
    public function removeServicesExploitant(\MairieVoreppe\DemandeTravauxBundle\Entity\ServiceExploitant $serviceExploitant = null)
    {
        $this->servicesExploitant->removeElement($serviceExploitant);

        return $this;
    }

    /**
     * Get mairie
     *
     * @return array \MairieVoreppe\DemandeTravauxBundle\Entity\Mairie
     */
    public function getServicesExploitant()
    {
        return $this->servicesExploitant;
    }
}
