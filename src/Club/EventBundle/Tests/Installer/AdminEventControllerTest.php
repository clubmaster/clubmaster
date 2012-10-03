<?php

namespace Club\EventBundle\Tests\Installer;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminEventControllerTest extends WebTestCase
{
    protected $client;

    public function __construct()
    {
        $this->client = static::createClient();
        $this->login($this->client);
    }

    public function testNew()
    {
        $crawler = $this->client->request('GET', '/en/admin/event/event/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form(array(
            'event[event_name]' => 'Big BBQ hangout',
            'event[description]' => 'Lorem ipsum'
        ));
        $crawler = $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testAttend()
    {
        $crawler = $this->client->request('GET', '/en/event');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $link = $crawler->selectLink('Show')->link();
        $crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $link = $crawler->selectLink('Attend')->link();
        $crawler = $this->client->click($link);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
