<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Observation;
use AppBundle\Entity\User;
use AppBundle\Entity\Bird;


class ObservationTypeTest extends WebTestCase
{
    public function testObservationTypeValidator()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $validator = $container->get('validator');

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

        // Observation 1
        $observation = new Observation();
        $observation->setUser($user);
        $observation->setBird($bird);
        $observation->setTitle('pigeon');
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

        $errors = $validator->validate($observation);
        $this->assertEquals(0, count($errors));
    }
}