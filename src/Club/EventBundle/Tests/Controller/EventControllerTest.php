<?php
namespace Club\EventBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => '10',
      'PHP_AUTH_PW' => '1234'
    ));
    $crawler = $client->request('GET', '/event/event');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testical()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/event/ical');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
