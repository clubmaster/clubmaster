<?php
namespace Club\BookingBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminIntervalControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/admin/booking/interval/1');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $crawler = $this->client->request('GET', '/admin/booking/interval/1/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testEdit()
  {
    $crawler = $this->client->request('GET', '/admin/booking/interval/edit/1');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testDelete()
  {
    $crawler = $this->client->request('GET', '/admin/booking/interval/1');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $links = $crawler->selectLink('Delete')->links();
    $crawler = $this->client->click(end($links));
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
