<?php

namespace Club\WelcomeBundle\Tests\Installer;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function __construct()
    {
        $this->client = static::createClient();
        $this->login($this->client);
    }

    public function testNew()
    {
        $crawler = $this->client->request('GET', '/en/welcome/blog/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form();
        $crawler = $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form(array(
            'blog[title]' => 'ClubMaster test subject',
            'blog[message]' => 'Welcome to ClubMaster, this is a test blog message :), Welcome to ClubMaster, this is a test blog message :)Welcome to ClubMaster, this is a test blog message :)',
        ));
        $crawler = $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
