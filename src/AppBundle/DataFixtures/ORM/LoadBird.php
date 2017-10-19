<?php
// src/AppBundle/DataFixtures/ORM/LoadBird.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Bird;

class LoadBird implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter
        $birds = array(
            array('Aigle Royal', 'Animalia', 'Phylum', 'ranking','family','lb_name','Donald'),
            array('Faucon', 'Animalia', 'Phylum', 'ranking','family','lb_name','Donald'),
            array('Moineau', 'Animalia', 'Phylum', 'ranking','family','lb_name','Donald'),
            array('Pigeon', 'Animalia', 'Phylum', 'ranking','family','lb_name','Donald'),


        );

        foreach ($birds as $element) {
            // On crée l'oiseau
            $bird = new Bird();
            $bird->setSpecies($element[0]);
            $bird->setReign($element[1]);
            $bird->setPhylum($element[2]);
            $bird->setRanking($element[3]);
            $bird->setFamily($element[4]);
            $bird->setLbName($element[5]);
            $bird->setLbAuthor($element[6]);

            // On la persiste
            $manager->persist($bird);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}