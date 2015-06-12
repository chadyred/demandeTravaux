<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace MairieVoreppe\DataFixtures\ORM\CategorieReseauOuvrage;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MairieVoreppe\DemandeTravauxBundle\Entity\CategorieReseauOuvrage;

class LoadCategorieReseauOuvrage implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    
    // Liste des noms de catégorie à ajouter
    $catROs = array(
      'HC' => 'Canalisations de transport et canalisations minières contenant des hydrocarbures liquides ou liquéfiés',
      'PC' => 'Canalisations de transport et canalisations minières contenant des produits chimiques liquides ou gazeux',
      'GA' => 'Canalisations de transport, de distribution et canalisations minières contenant des gaz combustibles ',
      'CU' => 'Canalisations de transport ou de distribution de vapeur d’eau, d’eau surchauffée, d’eau chaude, d’eau glacée, et de tout 
fluide caloporteur ou frigorigène, et tuyauteries rattachées en raison de leur connexité à des installations classées pour la 
protection de l’environnement',
      'EL' => 'Lignes électriques et réseaux d’éclairage public autres qu’en très basse tension (> 50 V en courant alternatif ou 90 V en 
courant continu)',
      'TR' => 'Installations destinées à la circulation de véhicules de transport public ferroviaire ou guidé ',
      'DE' => 'Canalisations de transport de déchets par dispositif pneumatique sous pression ou par aspiration',
      'TL' => 'Installations souterraines de communications électroniques, lignes électriques et réseaux d’éclairage public en très basse 
tension (≤ 50 V en courant alternatif ou 90 V en courant continu) ',
      'EA' => 'Canalisations souterraines de prélèvement et de distribution d’eau destinée à la consommation humaine, à l’alimentation en 
eau industrielle ou à la protection contre l’incendie, en pression ou à écoulement libre, y compris les réservoirs d’eau 
enterrés qui leur sont associés ',
      'EU' => 'Canalisations souterraines d’assainissement, contenant des eaux usées domestiques ou industrielles ou des eaux pluviales',
    );

    foreach ($catROs as $code => $description) {
      // On crée la CategorieReseauOuvrage 
      $catRO = new CategorieReseauOuvrage();
      $catRO->setDescription($description);
      $catRO->setCode($code);

      // On la persiste
      $manager->persist($catRO);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}