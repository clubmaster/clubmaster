<?php
namespace Club\TeamBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class TeamControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/en/team/team');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testAttend()
  {
    $crawler = $this->client->request('GET', '/en/team/team/1/attend');
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testUnattend()
  {
    $crawler = $this->client->request('GET', '/en/team/team/1/unattend');
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
