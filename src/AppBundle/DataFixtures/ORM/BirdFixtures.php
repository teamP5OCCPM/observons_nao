<?php
// src/AppBundle/DataFixtures/ORM/LoadBird.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Bird;

class BirdFixtures extends Fixture
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager) : void
    {
        //Bird 1
        $bird = new Bird();
        $bird->setSpecies('Aigle Royal');
        $bird->setReign('Animalia');
        $bird->setPhylum('Phylum');
        $bird->setRanking('Ranking');
        $bird->setFamily('Family');
        $bird->setLbName('lb_name');
        $bird->setLbAuthor('Donald');
        $bird->setCdRef(1234);

        // Bird2
        $bird2 = new Bird();
        $bird2->setSpecies('Pigeon');
        $bird2->setReign('Animalia');
        $bird2->setPhylum('Phylum');
        $bird2->setRanking('Ranking');
        $bird2->setFamily('Family');
        $bird2->setLbName('lb_name');
        $bird2->setLbAuthor('Donald');
        $bird2->setCdRef(1235);

        // Bird3
        $bird3 = new Bird();
        $bird3->setSpecies('Colibri');
        $bird3->setReign('Animalia');
        $bird3->setPhylum('Phylum');
        $bird3->setRanking('Ranking');
        $bird3->setFamily('Family');
        $bird3->setLbName('lb_name');
        $bird3->setLbAuthor('Donald');
        $bird3->setCdRef(1236);

        // Bird4
        $bird4 = new Bird();
        $bird4->setSpecies('Canard');
        $bird4->setReign('Animalia');
        $bird4->setPhylum('Phylum');
        $bird4->setRanking('Ranking');
        $bird4->setFamily('Family');
        $bird4->setLbName('lb_name');
        $bird4->setLbAuthor('Donald');
        $bird4->setCdRef(1237);

        // On persiste
        $manager->persist($bird);
        $manager->persist($bird2);
        $manager->persist($bird3);
        $manager->persist($bird4);
        // On déclenche l'enregistrement de toutes les objets
        $manager->flush();

        // On ajoute l'objet dans une variable globale
        $this->addReference('bird', $bird);
        $this->addReference('bird2', $bird2);
        $this->addReference('bird3', $bird3);
        $this->addReference('bird4', $bird4);
    }
}
