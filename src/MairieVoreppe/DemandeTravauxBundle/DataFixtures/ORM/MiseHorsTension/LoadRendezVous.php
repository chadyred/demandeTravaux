<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace MairieVoreppe\DataFixtures\ORM\MiseHorsTension;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MairieVoreppe\DemandeTravauxBundle\Entity\MiseHorsTension;

class LoadMiseHorsTension implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de type de rendez-vous à ajouter
    $arrMiseHorsTension = array(
      'Possible',
      'Impossible'
    );

    foreach ($arrMiseHorsTension as $libelle) {
      // On crée la civilité
      $typeMiseHorsTension = new MiseHorsTension();
      $typeMiseHorsTension->setLibelle($libelle);

      // On la persiste
      $manager->persist($typeMiseHorsTension);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}