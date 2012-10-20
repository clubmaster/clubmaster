<?php
namespace Club\APIBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class UserControllerTest extends WebTestCase
{
  public function testTeams()
  {
    $client = $this->apiLogin();

    $crawler = $client->request('GET', '/api/users/teams');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
