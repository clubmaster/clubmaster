<?php
namespace Club\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CheckoutControllerTest extends WebTestCase
{
  protected function login($client)
  {
    $crawler = $client->request('GET', '/login');
    $form = $crawler->selectButton('Sign In')->form();
    $form['_username'] = '10';
    $form['_password'] = '1234';
    $crawler = $client->submit($form);
  }

  public function testEmptyCart()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/shop/product/1');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Put in cart')->link();
    $crawler = $client->click($link);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
    $crawler = $client->followRedirect();

    $link = $crawler->selectLink('Empty cart')->link();
    $crawler = $client->click($link);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }

  public function testCheckout()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/shop/product/1');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Put in cart')->link();
    $crawler = $client->click($link);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
    $crawler = $client->followRedirect();

    $link = $crawler->selectLink('Checkout')->link();
    $crawler = $client->click($link);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
    $crawler = $client->followRedirect();

    $this->assertEquals(302, $client->getResponse()->getStatusCode());
    $crawler = $client->followRedirect();

    $this->assertEquals(200, $client->getResponse()->getStatusCode());
    $form = $crawler->selectButton('Confirm order')->form();
    $crawler = $client->submit($form);

    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
