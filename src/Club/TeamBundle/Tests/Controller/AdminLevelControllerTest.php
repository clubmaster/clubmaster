<?php
namespace Club\TeamBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminLevelControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/admin/team/level');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $crawler = $this->client->request('GET', '/admin/team/level/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'level[level_name]' => 'Test',
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testDelete()
  {
    $crawler = $this->client->request('GET', '/admin/team/level');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $links = $crawler->selectLink('Delete')->links();
    $crawler = $this->client->click(end($links));
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
