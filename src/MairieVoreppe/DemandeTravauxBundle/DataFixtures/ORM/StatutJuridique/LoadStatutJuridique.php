<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace MairieVoreppe\DataFixtures\ORM\Ville;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MairieVoreppe\DemandeTravauxBundle\Entity\StatutJuridique;

class LoadStatutJuridique implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $statutJuridiques = array(
      'Entreprise Individuelle' => 'Entreprise Individuelle',
      'Société Civile Immobilière' => 'SCI',
      'Société Civile Professionnelle' => 'SCP',
      'Société Civile de Moyens' => 'SCM',
      'Entreprise Unipersonnelle à Responsabilité Limitée.' => 'EURL ',
      'Société à Responsabilité Limitée' => 'SARL',
      'Société par Actions Simplifiée' => 'SAS',
      'Société Anonyme' => 'SA'
    );

    foreach ($statutJuridiques as $libelle => $abreviation) {
      // On crée le statut juridique
      $statutJuridique = new StatutJuridique();
      $statutJuridique->setLibelle($libelle);
      $statutJuridique->setAbreviation($abreviation);

      // On la persiste
      $manager->persist($statutJuridique);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}