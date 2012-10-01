<?php

namespace Club\MatchBundle\Tests\Installer;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class MatchControllerTest extends WebTestCase
{
    protected $client;

    public function __construct()
    {
        $this->client = static::createClient();
        $this->login($this->client);
    }

    public function testNew()
    {
        $matches = 5;

        for ($i = 0; $i < $matches; $i++) {
            $crawler = $this->client->request('GET', '/en/match/match/new');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $form = $crawler->selectButton('Save')->form();
            $crawler = $this->client->submit($form);
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $form = $crawler->selectButton('Save')->form(array(
                'form[user0]' => 1,
                'form[user1]' => 2,
                'form[user0set0]' => 6,
                'form[user0set1]' => 6,
                'form[user0set2]' => 6,
                'form[user1set0]' => rand(0,4),
                'form[user1set1]' => rand(0,4),
                'form[user1set2]' => rand(0,4)
            ));
            $crawler = $this->client->submit($form);
            $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

            $comment = (rand(0,1)) ? true : false;

            if ($comment) {
                $crawler = $this->client->followRedirect();
                $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

                $link = $crawler->selectLink('Comment')->link();
                $crawler = $this->client->click($link);

                $form = $crawler->selectButton('Save')->form();
                $crawler = $this->client->submit($form);
                $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

                $form = $crawler->selectButton('Save')->form(array(
                    'match_comment[comment]' => 'Lorem ipsum..'
                ));
                $crawler = $this->client->submit($form);
                $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
            }
        }
    }
}
