<?php
namespace Club\APIBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class EventControllerTest extends WebTestCase
{
  public function testEvents()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/api/events/');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testAttend()
  {
    $client = $this->apiLogin();

    $crawler = $client->request('POST', '/api/events/1/attend');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testUnattend()
  {
    $client = $this->apiLogin();

    $crawler = $client->request('POST', '/api/events/1/unattend');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
