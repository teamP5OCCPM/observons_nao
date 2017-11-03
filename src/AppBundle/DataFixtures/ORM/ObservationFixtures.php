<?php
// src/AppBundle/DataFixtures/ORM/LoadBird.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Observation;

class ObservationFixtures extends Fixture
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager) : void
    {
        // Observation 1
        $observation = new Observation();
        $observation->setUser($this->getReference('user'));
        $observation->setBird($this->getReference('bird'));
        $observation->setTitle('Aigle royal en montagne');
        $observation->setImageName('01.jpg');
        $observation->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec sapien sed orci elementum bibendum. Duis nisi diam, pharetra eu tempor sit amet, lacinia a mi. Suspendisse posuere massa ut augue feugiat consequat. Vivamus vel mattis justo. Nulla mollis est nec lacus tincidunt, laoreet fermentum orci aliquam. Sed at dui varius, rutrum elit ut, dignissim est. Pellentesque aliquet molestie sem, a dapibus tellus. Pellentesque ut purus vel velit elementum auctor vel ac enim. Sed pellentesque, lacus in sagittis tristique, urna tortor varius tortor, at porttitor leo tellus ac risus. Aenean sit amet turpis eget felis semper laoreet.');
        $observation->setCreatedAt(new \DateTime());
        $observation->setObservedAt(new \DateTime());
        $observation->setUpdatedAt(new \DateTime("2017/10/26"));
        $observation->setLng('1.085325');
        $observation->setLat('42.800503');
        $observation->setCity('Bethmale');
        $observation->setStatus('validate');
        $observation->setSlug('aigle-royal-en-montagne');

        // Observation 2
        $observation2 = new Observation();
        $observation2->setUser($this->getReference('user2'));
        $observation2->setBird($this->getReference('bird2'));
        $observation2->setTitle('Pigeon de Paris');
        $observation2->setImageName('02.jpg');
        $observation2->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec sapien sed orci elementum bibendum. Duis nisi diam, pharetra eu tempor sit amet, lacinia a mi. Suspendisse posuere massa ut augue feugiat consequat. Vivamus vel mattis justo. Nulla mollis est nec lacus tincidunt, laoreet fermentum orci aliquam. Sed at dui varius, rutrum elit ut, dignissim est. Pellentesque aliquet molestie sem, a dapibus tellus. Pellentesque ut purus vel velit elementum auctor vel ac enim. Sed pellentesque, lacus in sagittis tristique, urna tortor varius tortor, at porttitor leo tellus ac risus. Aenean sit amet turpis eget felis semper laoreet.');
        $observation2->setCreatedAt(new \DateTime());
        $observation2->setObservedAt(new \DateTime());
        $observation2->setUpdatedAt(new \DateTime("2017/10/26"));
        $observation2->setLng('1.085325');
        $observation2->setLat('42.800503');
        $observation2->setCity('Bethmale');
        $observation2->setStatus('waiting');
        $observation2->setSlug('faucon-royal-en-montagne');

        // Observation 3
        $observation3 = new Observation();
        $observation3->setUser($this->getReference('user3'));
        $observation3->setBird($this->getReference('bird3'));
        $observation3->setTitle('Les colibris');
        $observation3->setImageName('03.jpg');
        $observation3->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec sapien sed orci elementum bibendum. Duis nisi diam, pharetra eu tempor sit amet, lacinia a mi. Suspendisse posuere massa ut augue feugiat consequat. Vivamus vel mattis justo. Nulla mollis est nec lacus tincidunt, laoreet fermentum orci aliquam. Sed at dui varius, rutrum elit ut, dignissim est. Pellentesque aliquet molestie sem, a dapibus tellus. Pellentesque ut purus vel velit elementum auctor vel ac enim. Sed pellentesque, lacus in sagittis tristique, urna tortor varius tortor, at porttitor leo tellus ac risus. Aenean sit amet turpis eget felis semper laoreet.');
        $observation3->setCreatedAt(new \DateTime());
        $observation3->setObservedAt(new \DateTime());
        $observation3->setUpdatedAt(new \DateTime("2017/10/26"));
        $observation3->setLng('1.085325');
        $observation3->setLat('42.800503');
        $observation3->setCity('Bethmale');
        $observation3->setStatus('refused');
        $observation3->setSlug('moineau-royal-en-montagne');

        // Observation 4
        $observation4 = new Observation();
        $observation4->setUser($this->getReference('user4'));
        $observation4->setBird($this->getReference('bird4'));
        $observation4->setTitle('Canetons au soleil');
        $observation4->setImageName('04.jpg');
        $observation4->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec sapien sed orci elementum bibendum. Duis nisi diam, pharetra eu tempor sit amet, lacinia a mi. Suspendisse posuere massa ut augue feugiat consequat. Vivamus vel mattis justo. Nulla mollis est nec lacus tincidunt, laoreet fermentum orci aliquam. Sed at dui varius, rutrum elit ut, dignissim est. Pellentesque aliquet molestie sem, a dapibus tellus. Pellentesque ut purus vel velit elementum auctor vel ac enim. Sed pellentesque, lacus in sagittis tristique, urna tortor varius tortor, at porttitor leo tellus ac risus. Aenean sit amet turpis eget felis semper laoreet.');
        $observation4->setCreatedAt(new \DateTime());
        $observation4->setObservedAt(new \DateTime());
        $observation4->setUpdatedAt(new \DateTime("2017/10/26"));
        $observation4->setLng('1.085325');
        $observation4->setLat('42.800503');
        $observation4->setCity('Bethmale');
        $observation4->setStatus('validate');
        $observation4->setSlug('pigeon-royal-en-montagne');

        //On persiste
        $manager->persist($observation);
        $manager->persist($observation2);
        $manager->persist($observation3);
        $manager->persist($observation4);

        for ($i = 0; $i < 30; $i++) {
            $observationD = new Observation();
            $observationD->setUser($this->getReference('user'));
            $observationD->setBird($this->getReference('bird'));
            $observationD->setTitle('Oiseau en montagne' . $i);
            $observationD->setImageName('default.jpg');
            $observationD->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec sapien sed orci elementum bibendum. Duis nisi diam, pharetra eu tempor sit amet, lacinia a mi. Suspendisse posuere massa ut augue feugiat consequat. Vivamus vel mattis justo. Nulla mollis est nec lacus tincidunt, laoreet fermentum orci aliquam. Sed at dui varius, rutrum elit ut, dignissim est. Pellentesque aliquet molestie sem, a dapibus tellus. Pellentesque ut purus vel velit elementum auctor vel ac enim. Sed pellentesque, lacus in sagittis tristique, urna tortor varius tortor, at porttitor leo tellus ac risus. Aenean sit amet turpis eget felis semper laoreet.');
            $observationD->setCreatedAt(new \DateTime());
            $observationD->setObservedAt(new \DateTime());
            $observationD->setUpdatedAt(new \DateTime("2017/10/26"));
            $observationD->setLng('1.085325');
            $observationD->setLat('42.800503');
            $observationD->setCity('Bethmale');
            $observationD->setStatus('validate');
            $observationD->setSlug('oiseau-en-montagne-' . $i);

            $manager->persist($observationD);
        }

        // On enregistre les objets
        $manager->flush();
    }

    // Détermine la dépendance de la fixtures Observation
    // Détermine donc l'ordre dans lequel les fixtures se font
    public function getDependencies()
    {
        return [
                UserFixtures::class,
            BirdFixtures::class
        ];
    }
}
