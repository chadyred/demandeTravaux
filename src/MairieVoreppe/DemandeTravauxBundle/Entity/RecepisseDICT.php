<?php

namespace MairieVoreppe\DemandeTravauxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use MairieVoreppe\DemandeTravauxBundle\Model\Recepisse;
use JMS\Serializer\Annotation\Groups;

/**
 * RecepisseDICT
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MairieVoreppe\DemandeTravauxBundle\Entity\RecepisseDICTRepository")
 */
class RecepisseDICT extends Recepisse
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
    * RecepisseDICT
    *
    * @ORM\OneToOne(targetEntity="MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT", mappedBy="recepisseDict")
    */
    private $dict;


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
     * Set dict
     *
     * @param \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict
     *
     * @return RecepisseDICT
     */
    public function setDict(\MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT $dict = null)
    {
        $this->dict = $dict;

        return $this;
    }

    /**
     * Get dict
     *
     * @return \MairieVoreppe\DemandeTravauxBundle\Entity\DemandeIntentionCT
     */
    public function getDict()
    {
        return $this->dict;
    }
}
