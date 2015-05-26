<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace MairieVoreppe\DataFixtures\ORM\Civilite;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MairieVoreppe\DemandeTravauxBundle\Entity\Civilite;

class LoadCivilite implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $civilites = array(
      'Monsieur' => 'M.',
      'Madame' => 'Mme',
      'Mademoiselle' => 'Mlle',
      'Veuve' => 'Vve',
      'Veuf' => 'Vfr'
    );

    foreach ($civilites as $titre => $abreviation) {
      // On crée la civilité
      $civilite = new Civilite();
      $civilite->setTitre($titre);
      $civilite->setAbreviation($abreviation);

      // On la persiste
      $manager->persist($civilite);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}