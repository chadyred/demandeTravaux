<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace MairieVoreppe\DataFixtures\ORM\DispositifSecurite;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MairieVoreppe\DemandeTravauxBundle\Entity\DispositifSecurite;

class LoadDispositifSecurite implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de type de rendez-vous à ajouter
    $arrDispositifSecurite = array(
      'Voir la liste des dispositifs en place dans le document joint',
      'Voir la localisation sur le plan joint',
      'Aucune dans l\'emprise'
    );

    foreach ($arrDispositifSecurite as $description) {
      // On crée la civilité
      $typeMiseHorsTension = new DispositifSecurite();
      $typeMiseHorsTension->setDescription($description);

      // On la persiste
      $manager->persist($typeMiseHorsTension);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}