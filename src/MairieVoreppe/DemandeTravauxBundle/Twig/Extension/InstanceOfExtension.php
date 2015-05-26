<?php
namespace MairieVoreppe\DemandeTravauxBundle\Twig\Extension;

use MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonnePhysique;

class InstanceOfExtension extends \Twig_Extension
{

    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        return array(
            new \Twig_SimpleTest('instanceof', array($this, 'isInstanceOf'))
        );
    }

    public function isInstanceOf($object, $class)
    {
        //Le chemin est complet en chaine doit être passé MairieVoreppe\DemandeTravauxBundle\Entity\MOAPersonnePhysique
        $reflectionClass = new \ReflectionClass($class);

        return $reflectionClass->isInstance($object);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'yolo';
    }
}