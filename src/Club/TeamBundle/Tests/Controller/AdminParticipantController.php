<?php
namespace Club\TeamBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminParticipantControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/en/admin/team/participant');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testParticipant()
  {
    $crawler = $this->client->request('GET', '/en/admin/team/participant/10');
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
