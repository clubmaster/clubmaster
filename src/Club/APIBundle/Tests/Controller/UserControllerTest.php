<?php
namespace Club\APIBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class UserControllerTest extends WebTestCase
{
  public function testUsers()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/api/users/');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testUser()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/api/users/10');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
