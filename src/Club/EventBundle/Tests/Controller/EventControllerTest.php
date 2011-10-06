<?php
namespace Club\EventBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class EventControllerTest extends WebTestCase
{
  public function __construct()
  {
    return;
  }

  public function testICal()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/event/ical');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
