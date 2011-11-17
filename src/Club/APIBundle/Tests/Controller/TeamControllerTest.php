<?php
namespace Club\APIBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class TeamControllerTest extends WebTestCase
{
  public function testTeams()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/api/teams/');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testAttend()
  {
    $client = $this->apiLogin();

    $crawler = $client->request('POST', '/api/teams/1/attend');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testUnattend()
  {
    $client = $this->apiLogin();

    $crawler = $client->request('POST', '/api/teams/1/unattend');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testParticipant()
  {
    $client = $this->apiLogin();

    $crawler = $client->request('POST', '/api/teams/participant');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

}
