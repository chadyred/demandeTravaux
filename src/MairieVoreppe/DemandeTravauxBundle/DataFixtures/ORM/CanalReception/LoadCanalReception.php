<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace MairieVoreppe\DataFixtures\ORM\Civilite;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MairieVoreppe\DemandeTravauxBundle\Entity\CanalReception;

class LoadCanalReception implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de canaux à ajouter
    $canaux = array(
      'Courrier', 
      'Fax', 
      'Mail'
    );

    foreach ($canaux as $canal) {
      // On crée le canal
      $unCanal = new CanalReception();
      $unCanal->setLibelle($canal);

      // On la persiste
      $manager->persist($unCanal);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}