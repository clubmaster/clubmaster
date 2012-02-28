<?php
namespace Club\TaskBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class TaskControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/admin/task/');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }
}
