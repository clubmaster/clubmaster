<?php
namespace Club\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SubscriptionControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => '10',
      'PHP_AUTH_PW' => '1234'
    ));
    $crawler = $client->request('GET', '/shop/subscription');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
