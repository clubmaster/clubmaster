<?php
namespace Club\ShopBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class CheckoutControllerTest extends WebTestCase
{
  protected $client;
  protected $coupon_key;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testCreateCoupon()
  {
    $this->coupon_key = uniqid();

    $crawler = $this->client->request('GET', '/en/admin/shop/coupon/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'coupon[value]' => '50',
      'coupon[coupon_key]' => $this->coupon_key
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testEmptyCart()
  {
    $crawler = $this->client->request('GET', '/en/shop/product/1');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Put in cart')->link();
    $crawler = $this->client->click($link);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();

    $link = $crawler->selectLink('Empty cart')->link();
    $crawler = $this->client->click($link);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testCheckout()
  {
    $crawler = $this->client->request('GET', '/en/shop/product/1');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Put in cart')->link();
    $crawler = $this->client->click($link);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();

    $link = $crawler->selectLink('Use coupon')->link();
    $crawler = $this->client->click($link);
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'form[coupon_key]' => $this->coupon_key
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();

    $link = $crawler->selectLink('Checkout')->link();
    $crawler = $this->client->click($link);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();

    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();

    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    $form = $crawler->selectButton('Confirm order')->form();
    $crawler = $this->client->submit($form);

    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testOrder()
  {
    $crawler = $this->client->request('GET', '/en/admin/shop/order');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $links = $crawler->selectLink('Edit')->links();
    $crawler = $this->client->click($links[0]);
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Pay order')->link();
    $crawler = $this->client->click($link);
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
