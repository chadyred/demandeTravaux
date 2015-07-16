<?php
namespace MairieVoreppe\UserBundle\Datafixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MairieVoreppe\UserBundle\Entity\User;

class Users implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
            $nomUtilisateurs = array('florian' => 'cellier.florian@hotmail.fr', 'veronique' => 'qsd@qsd.com');
            $i = 0;

            foreach($nomUtilisateurs as $unNomUtilisateur => $mail)
            {
                    $utilisateur[$i] = new User();

                    $utilisateur[$i]->setUsername($unNomUtilisateur);
                    $utilisateur[$i]->setPassword($unNomUtilisateur . 'pass');
                    $utilisateur[$i]->setEmail($mail);

                    $utilisateur[$i]->setRoles(array());

                    $manager->persist($utilisateur[$i]);
                    $i++;
            }

            $manager->flush();
	}
}
?>