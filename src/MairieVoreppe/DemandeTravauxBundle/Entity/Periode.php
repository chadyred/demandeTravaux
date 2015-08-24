<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//On va mettre le namespace de notre méthode Classe interface Constraints de notre validator
use Symfony\Component\Validator\Constraints as Assert;
//Permet de récupérer les valeur des objets en cours de vie dans notre classe
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Periode
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\PeriodeRepository")
 * @Assert\Callback(methods={"isPeriodeValid"})
 */
class Periode
{
   /**
    * @var \integer
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;
    
     /**
     * @var \$responsableExploitant 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\ResponsableExploitant", inversedBy="periodes", cascade={"persist"})
     * @Assert\Valid()
     */
    private $responsableExploitant;
    
     /**
     * @var \$mairie
      * 
     * @ORM\ManyToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant", inversedBy="periodes")
     * @Assert\Valid()
     */
    private $exploitant;
    

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;


    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Periode
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Periode
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
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
     * Set responsableExploitant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\ResponsableExploitant $responsableExploitant
     *
     * @return Periode
     */
    public function setResponsableExploitant(\MairieVoreppe\DemandeTravauxBundle\Entity\ResponsableExploitant $responsableExploitant)
    {
        $this->responsableExploitant = $responsableExploitant;


        return $this;
    }

    /**
     * Get responsableExploitant
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\ResponsableExploitant
     */
    public function getResponsableExploitant()
    {
        return $this->responsableExploitant;
    }

    /**
     * Set exploitant
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant $exploitant
     *
     * @return Periode
     */
    public function setExploitant(\MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant $exploitant)
    {
        $this->exploitant = $exploitant;
        return $this;
    }

    /**
     * Get exploitant
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\Exploitant
     */
    public function getExploitant()
    {
        return $this->exploitant;
    }

    /**
    * Condition de validation personalisée pour les périodes: 
    *   - la date de début ne peut pas être antérieur à la date de fin
    *   - si la période ne chevauche pas une autre. Date de debut et de fin non présente entre date début et fin. 
    *    (bien penser si la date englobe une période complète)
    */
    public function isPeriodeValid(ExecutionContextInterface $context)
    {
        //format : Retourne la date formatée, sous forme de chaîne de caractères, en cas de succès ou FALSE si une erreur survient.
        
        if($this->getDateDebut() > $this->getDateFin())
        {
            //Mise à jour
            //$context->addViolationAt('duree', 'Veuillez indiquer une durée plus grande que 0 !', array(), null);
            $context->buildViolation('La date de fin ne peut pas être antérieur à la date de début !')
                    ->atPath('periodes')
                    ->addViolation();
        }

        foreach($this->getExploitant()->getPeriodes() as $periode)
        {
            if(($this->getDateDebut() > $periode->getDateDebut() && $this->getDateDebut() < $periode->getDateFin()) 
                || ($this->getDateFin() > $periode->getDateDebut() && $this->getDateFin() < $periode->getDateFin()) )
            {
                    //Mise à jour
                    //$context->addViolationAt('duree', 'Veuillez indiquer une durée plus grande que 0 !', array(), null);
                    $context->buildViolation('La date en chevauche une autre ! Il s\'agit de celle de {{ exploitant }} ')
                    ->atPath('periodes')
                    ->setParameter('{{ exploitant }}', $periode->getResponsableExploitant())
                    ->addViolation();
            }
            else
            {
                //Cas de la date qui inclus une date complète                 Date début-> |        <- Une période ->   | <- Date fin        |
                 if($this->getDateDebut() < $periode->getDateDebut() && $this->getDateFin() > $periode->getDateDebut())
                {
                    //Mise à jour
                    //$context->addViolationAt('duree', 'Veuillez indiquer une durée plus grande que 0 !', array(), null);
                    $context->buildViolation('la date couvre une date complétement ! Il s\'agit de celle de {{ exploitant }} ')
                    ->atPath('periodes')
                    ->setParameter('{{ exploitant }}', $periode->getResponsableExploitant())
                    ->addViolation();
                }
            }
        }

        
    }

}
