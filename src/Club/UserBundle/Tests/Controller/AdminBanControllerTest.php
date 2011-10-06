<?php
namespace Club\UserBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminBanControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/ban');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
