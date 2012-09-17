<?php
namespace Club\DashboardBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class DashboardControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/en/admin/dashboard');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }
}
