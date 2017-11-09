<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Bird;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class CoreControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient([], [
                'PHP_AUTH_USER' => 'user',
                'PHP_AUTH_PW' => '1234'
        ]);
    }

    /**
     * @dataProvider UrlsProvider
     */
    public function testUrls($url, $content)
    {
        $this->logIn();
        $container = $this->client->getContainer();

        $crawler = $this->client->request('GET', $url);
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains($content, $response->getContent());
    }

    public function UrlsProvider()
    {
        return [
            ['/', 'Observez'],
            ['/ajouter-observation', 'Envoyer'],
            ['/les-observations/1', 'Les observations'],
            ['/blog/1', 'Les articles'],
            ['/contact', 'Contactez-nous'],
            ['/login', 'Connectez-vous'],
            ['/qui-sommes-nous', 'Qui sommes nous'],
            ['/pourquoi-ce-site', 'Pourquoi ce site']
        ];
    }


    public function testAddObservation()
    {
        $bird = new Bird();
        $bird->setSpecies('444');
        $bird->setReign('Animalia');
        $bird->setPhylum('Phylum');
        $bird->setRanking('Ranking');
        $bird->setFamily('Family');
        $bird->setLbName('lb_name');
        $bird->setLbAuthor('Donald');
        $bird->setCdRef(1234);

        $this->logIn();
        $crawler = $this->client->request('GET', '/ajouter-observation');
        $form = $crawler->selectButton('appbundle_observation_save')->form();
        $form['appbundle_observation[title]'] = 'Titre de l\'observation';
        $form['appbundle_observation[bird]'] = $bird;
        $form['appbundle_observation[lng]'] = 0.7051413;
        $form['appbundle_observation[lat]'] = 47.378294399999994;
        $form['appbundle_observation[observedAt][day]'] = '09';
        $form['appbundle_observation[observedAt][month]'] = '11';
        $form['appbundle_observation[observedAt][year]'] = '2017';
        $form['appbundle_observation[description]'] = 'blabla';
        $crawler = $this->client->submit($form);
        echo $client->getResponse()->getContent();
//        $crawler = $this->client->followRedirect();

//        $this->assertSame(1, $crawler->filter('div.alert')->count());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'secured_area';

        $token = new UsernamePasswordToken('user', null, $firewallContext, array('ROLE_USER'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
