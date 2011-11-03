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
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => '10',
      'PHP_AUTH_PW' => '1234'
    ));
    $crawler = $client->request('POST', '/api/events/1/attend');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testUnattend()
  {
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => '10',
      'PHP_AUTH_PW' => '1234'
    ));

    $crawler = $client->request('POST', '/api/events/1/unattend');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
