<?php
namespace Club\APIBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class UserControllerTest extends WebTestCase
{
  public function testUsers()
  {
    return;
    $client = $this->apiKey();

    $crawler = $client->request('GET', '/api/users/', array(), array(), array(
      'API_KEY' => 'THIS_IS_A_DEMO_KEY'
    ));
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testUser()
  {
    return;
    $client = $this->apiKey();
    $crawler = $client->request('GET', '/api/users/10');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testTeams()
  {
    $client = $this->apiLogin();

    $crawler = $client->request('GET', '/api/users/teams');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

}
