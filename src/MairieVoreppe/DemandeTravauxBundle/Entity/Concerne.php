<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MairieVoreppe\DemandeTravauxBundle\Model\Reponse;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Concerne
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\ConcerneRepository")
 */
class Concerne extends Reponse
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
    * Doctrine Array
    *
    * Liste des catégorie réseau concernée de l'exploitant Mairie
    *
    * @ORM\ManyToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\CategorieReseauOuvrage")
    * @Groups({"reponse_recepisse"})
    */
    private $categorieReseauOuvrage;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categorieReseauOuvrage = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add categorieReseauOuvrage
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\CategorieReseauOuvrage $categorieReseauOuvrage
     *
     * @return Concerne
     */
    public function addCategorieReseauOuvrage(\MairieVoreppe\DemandeTravauxBundle\Entity\CategorieReseauOuvrage $categorieReseauOuvrage)
    {
        $this->categorieReseauOuvrage[] = $categorieReseauOuvrage;

        return $this;
    }

    /**
     * Remove categorieReseauOuvrage
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\CategorieReseauOuvrage $categorieReseauOuvrage
     */
    public function removeCategorieReseauOuvrage(\MairieVoreppe\DemandeTravauxBundle\Entity\CategorieReseauOuvrage $categorieReseauOuvrage)
    {
        $this->categorieReseauOuvrage->removeElement($categorieReseauOuvrage);
    }

    /**
     * Get categorieReseauOuvrage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategorieReseauOuvrage()
    {
        return $this->categorieReseauOuvrage;
    }

    


    public function __toString()
    {
        return "Concerné";
    }
}
