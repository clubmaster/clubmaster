<?php
namespace Club\APIBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AuthControllerTest extends WebTestCase
{
  public function testAuth()
  {
    $client = $this->apiLogin();

    $crawler = $client->request('GET', '/api/auth');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
