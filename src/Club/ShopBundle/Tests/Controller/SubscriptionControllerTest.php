<?php
namespace Club\ShopBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class SubscriptionControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/en/shop/subscription');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
