<?php
namespace Club\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminCouponControllerTest extends WebTestCase
{
  protected function login($client)
  {
    $crawler = $client->request('GET', '/login');
    $form = $crawler->selectButton('Sign In')->form(array(
      '_username' => '10',
      '_password' => '1234'
    ));
    $crawler = $client->submit($form);
  }

  public function testIndex()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/shop/coupon');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/shop/coupon/new');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'coupon[value]' => '122'
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }

  public function testExpire()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/shop/coupon');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Expire')->link();
    $crawler = $client->click($link);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
