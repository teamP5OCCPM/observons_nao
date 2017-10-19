<?php
// src/AppBundle/DataFixtures/ORM/LoadBird.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class UserFixtures extends Fixture
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager) : void
    {
        //user1
        $user = new User();
        $user->setFirstName('Jean-Maurice');
        $user->setLastName('Birdman');
        $user->setNewsletter(false);

        //user2
        $user2 = new User();
        $user2->setFirstName('Jean-Mouloud');
        $user2->setLastName('Eagleman');
        $user2->setNewsletter(false);

        $manager->persist($user);
        $manager->persist($user2);
        $manager->flush();

        $this->addReference('user', $user);
        $this->addReference('user2', $user2);
    }
}
