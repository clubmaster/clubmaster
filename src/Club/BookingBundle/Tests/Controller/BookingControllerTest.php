<?php
namespace Club\BookingBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class BookingControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/booking');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testBookUser()
  {
    $date = new \DateTime("Next monday");

    $crawler = $this->client->request('GET', '/booking/book/1/'.$date->format('Y-m-d'));
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();
    var_dump($this->client->getResponse());die();

    $form = $crawler->selectButton('Save')->form(array(
      'user[member_number]' => '1'
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
