<?php
namespace Club\ShopBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class ShopControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/shop');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Ticket coupon')->link();
    $crawler = $client->click($link);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('10 clip')->link();
    $crawler = $client->click($link);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
