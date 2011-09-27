<?php
namespace Club\EventBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/event/ical');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
