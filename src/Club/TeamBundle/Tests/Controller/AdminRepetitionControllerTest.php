<?php
namespace Club\TeamBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminRepetitionControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testNew()
  {
    $crawler = $this->client->request('GET', '/admin/team/team/1/schedule/1/repetition/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $forms = $crawler->selectButton('Save')->forms();
    $crawler = $this->client->submit($forms[0]);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
