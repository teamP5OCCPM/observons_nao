<?php
// src/AppBundle/DataFixtures/ORM/LoadBird.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class UserFixtures extends Fixture
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        //user1
        $user = new User();
        $user->setUsername('user');
        $user->setEmail('Jean-User@test.fr');
        $user->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user->setFirstName('Jean-User');
        $user->setLastName('Birdman');
        $user->setNewsletter(false);
        $user->setRoles(["ROLE_USER"]);
        $user->setEnabled(1);

        //user2
        $user2 = new User();
        $user2->setUsername('naturalist');
        $user2->setEmail('Jean-Naturalist@test.fr');
        $user2->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user2->setFirstName('Jean-Naturalist');
        $user2->setLastName('Birdman');
        $user2->setNewsletter(false);
        $user2->setRoles(["ROLE_NATURALIST"]);
        $user2->setEnabled(1);

        //user3
        $user3 = new User();
        $user3->setUsername('editor');
        $user3->setEmail('Jean-Editor@test.fr');
        $user3->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user3->setFirstName('Jean-Editor');
        $user3->setLastName('Birdman');
        $user3->setNewsletter(false);
        $user3->setRoles(["ROLE_EDITOR"]);
        $user3->setEnabled(1);

        //user4
        $user4 = new User();
        $user4->setUsername('admin');
        $user4->setEmail('Jean-Admin@test.fr');
        $user4->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $user4->setFirstName('Jean-Admin');
        $user4->setLastName('Birdman');
        $user4->setNewsletter(false);
        $user4->setRoles(["ROLE_ADMIN"]);
        $user4->setEnabled(1);


        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->flush();

        $this->addReference('user', $user);
        $this->addReference('user2', $user2);
        $this->addReference('user3', $user3);
        $this->addReference('user4', $user4);
    }
}
