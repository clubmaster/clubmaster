<?php

namespace Club\RankingBundle\Tests\Installer;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminRankingControllerTest extends WebTestCase
{
    protected $client;

    public function __construct()
    {
        $this->client = static::createClient();
        $this->login($this->client);
    }

    public function testNewRule()
    {
        $crawler = $this->client->request('GET', '/en/admin/ranking/rule/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form(array(
            'rule[name]' => 'Default'
        ));
        $crawler = $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testNew()
    {
        $crawler = $this->client->request('GET', '/en/admin/ranking/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form(array(
            'ranking[name]' => date('Y')
        ));
        $crawler = $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
