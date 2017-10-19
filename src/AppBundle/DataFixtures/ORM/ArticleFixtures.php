<?php
// src/AppBundle/DataFixtures/ORM/LoadBird.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Article;

class ArticleFixtures extends Fixture
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager) : void
    {
        // article1
        $article = new Article();
        $article->setUser($this->getReference('user'));
        $article->setImage('img/a01.jpg');
        $article->setTitle('Mon premier article');
        $article->setSlug('mon-premier-article');
        $article->setCreatedAt(new \DateTime());
        $article->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec sapien sed orci elementum bibendum. Duis nisi diam, pharetra eu tempor sit amet, lacinia a mi. Suspendisse posuere massa ut augue feugiat consequat. Vivamus vel mattis justo. Nulla mollis est nec lacus tincidunt, laoreet fermentum orci aliquam. Sed at dui varius, rutrum elit ut, dignissim est. Pellentesque aliquet molestie sem, a dapibus tellus. Pellentesque ut purus vel velit elementum auctor vel ac enim. Sed pellentesque, lacus in sagittis tristique, urna tortor varius tortor, at porttitor leo tellus ac risus. Aenean sit amet turpis eget felis semper laoreet.');
        $article->setIsPublished(true);

        // article2
        $article2 = new Article();
        $article2->setUser($this->getReference('user2'));
        $article2->setImage('img/a02.jpg');
        $article2->setTitle('Mon deuxième article');
        $article2->setSlug('mon-deuxième-article');
        $article2->setCreatedAt(new \DateTime());
        $article2->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec sapien sed orci elementum bibendum. Duis nisi diam, pharetra eu tempor sit amet, lacinia a mi. Suspendisse posuere massa ut augue feugiat consequat. Vivamus vel mattis justo. Nulla mollis est nec lacus tincidunt, laoreet fermentum orci aliquam. Sed at dui varius, rutrum elit ut, dignissim est. Pellentesque aliquet molestie sem, a dapibus tellus. Pellentesque ut purus vel velit elementum auctor vel ac enim. Sed pellentesque, lacus in sagittis tristique, urna tortor varius tortor, at porttitor leo tellus ac risus. Aenean sit amet turpis eget felis semper laoreet.');
        $article2->setIsPublished(true);

        // article3
        $article3 = new Article();
        $article3->setUser($this->getReference('user'));
        $article3->setImage('img/a03.jpg');
        $article3->setTitle('Mon troisième article');
        $article3->setSlug('mon-troisième-article');
        $article3->setCreatedAt(new \DateTime());
        $article3->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec sapien sed orci elementum bibendum. Duis nisi diam, pharetra eu tempor sit amet, lacinia a mi. Suspendisse posuere massa ut augue feugiat consequat. Vivamus vel mattis justo. Nulla mollis est nec lacus tincidunt, laoreet fermentum orci aliquam. Sed at dui varius, rutrum elit ut, dignissim est. Pellentesque aliquet molestie sem, a dapibus tellus. Pellentesque ut purus vel velit elementum auctor vel ac enim. Sed pellentesque, lacus in sagittis tristique, urna tortor varius tortor, at porttitor leo tellus ac risus. Aenean sit amet turpis eget felis semper laoreet.');
        $article3->setIsPublished(true);

        // article4
        $article4 = new Article();
        $article4->setUser($this->getReference('user2'));
        $article4->setImage('img/a04.jpg');
        $article4->setTitle('Mon quatrième article');
        $article4->setSlug('mon-quatrième-article');
        $article4->setCreatedAt(new \DateTime());
        $article4->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec sapien sed orci elementum bibendum. Duis nisi diam, pharetra eu tempor sit amet, lacinia a mi. Suspendisse posuere massa ut augue feugiat consequat. Vivamus vel mattis justo. Nulla mollis est nec lacus tincidunt, laoreet fermentum orci aliquam. Sed at dui varius, rutrum elit ut, dignissim est. Pellentesque aliquet molestie sem, a dapibus tellus. Pellentesque ut purus vel velit elementum auctor vel ac enim. Sed pellentesque, lacus in sagittis tristique, urna tortor varius tortor, at porttitor leo tellus ac risus. Aenean sit amet turpis eget felis semper laoreet.');
        $article4->setIsPublished(true);

        // On persiste
        $manager->persist($article);
        $manager->persist($article2);
        $manager->persist($article3);
        $manager->persist($article4);
        // On déclenche l'enregistrement de toutes les objets
        $manager->flush();
    }

    // Détermine la dépendance de la fixtures Observation
    // Détermine donc l'ordre dans lequel les fixtures se font
    public function getDependencies()
    {
        return [
                UserFixtures::class
        ];
    }
}
