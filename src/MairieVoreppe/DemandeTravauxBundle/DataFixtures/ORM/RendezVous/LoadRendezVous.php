<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace MairieVoreppe\DataFixtures\ORM\RendezVous;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MairieVoreppe\DemandeTravauxBundle\Entity\TypeRendezVous;

class LoadRendezVous implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de type de rendez-vous à ajouter
    $arrRendezVous = array(
      'Date retenue d’un commun accord',
      'Prise de RDV à l’initiative du déclarant'
    );

    foreach ($arrRendezVous as $libelle) {
      // On crée la civilité
      $typeRendezVous = new TypeRendezVous();
      $typeRendezVous->setLibelle($libelle);

      // On la persiste
      $manager->persist($typeRendezVous);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}