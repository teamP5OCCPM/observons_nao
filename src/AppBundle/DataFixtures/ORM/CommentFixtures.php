<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Comment;

class CommentFixtures extends Fixture
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager): void
    {
        // comment1
        $comment = new Comment();
        $comment->setArticle($this->getReference('article3'));
        $comment->setAuthor('sebius');
        $comment->setEmail('sebgaudin@yahoo.fr');
        $comment->setMessage('Test de commentaire');

        // comment2
        $comment2 = new Comment();
        $comment2->setParent($comment);
        $comment2->setAuthor('sebius');
        $comment2->setEmail('sebgaudin@yahoo.fr');
        $comment2->setMessage('Réponse commentaire');

        // comment3
        $comment3 = new Comment();
        $comment3->setParent($comment2);
        $comment3->setAuthor('sebius');
        $comment3->setEmail('sebgaudin@yahoo.fr');
        $comment3->setMessage('Réponse commentaire 2');

        $manager->persist($comment);
        $manager->persist($comment2);
        $manager->persist($comment3);

        $manager->flush();
    }

    // Détermine la dépendance de la fixtures Observation
    // Détermine donc l'ordre dans lequel les fixtures se font
    public function getDependencies()
    {
        return [
            ArticleFixtures::class
        ];
    }
}
