<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ArreteModel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\ArreteModelRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ArreteModel
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
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    
    /**
     * Tout arrêté ne sera pas supprimable même si la DICT est supprimée. 
     * 
     * @ORM\OneToMany(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\ArretePromulgue", mappedBy="arreteModel")
     * 
     * @var type 
     */
    private $arretesPromulgues;
    

    
    
                          /*******************
                            Upload Avatar
                            *******************/
   

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->arretesPromulgues = new \Doctrine\Common\Collections\ArrayCollection(); 
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
     * Set titre
     *
     * @param string $titre
     *
     * @return ArreteModel
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return ArreteModel
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Add arretesPromulgue
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\ArretePromulgue $arretesPromulgue
     *
     * @return ArreteModel
     */
    public function addArretesPromulgue(\MairieVoreppe\DemandeTravauxBundle\Entity\ArretePromulgue $arretesPromulgue)
    {
        $this->arretesPromulgues[] = $arretesPromulgue;

        return $this;
    }

    /**
     * Remove arretesPromulgue
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Model\ArretePromulgue $arretesPromulgue
     */
    public function removeArretesPromulgue(\MairieVoreppe\DemandeTravauxBundle\Entity\ArretePromulgue $arretesPromulgue)
    {
        $this->arretesPromulgues->removeElement($arretesPromulgue);
    }

    /**
     * Get arretesPromulgues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArretesPromulgues()
    {
        return $this->arretesPromulgues;
    }  

}
