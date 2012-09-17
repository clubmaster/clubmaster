<?php
namespace Club\ShopBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class GuestCheckoutControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
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

    $link = $crawler->selectLink('Checkout')->link();
    $crawler = $this->client->click($link);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();

    $form = $crawler->selectButton('Create account')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Create account')->form(array(
      'user[profile][first_name]' => 'Michael Holm',
      'user[profile][last_name]' => 'Kristensen',
      'user[profile][day_of_birth]' => '1984-06-29',
      'user[profile][profile_address][street]' => 'Oesterbro 62, 2tv',
      'user[profile][profile_address][postal_code]' => '9000',
      'user[profile][profile_address][city]' => 'Aalborg',
      'user[profile][profile_address][country]' => 'DK',
      'user[profile][profile_emails][0][email_address]' => 'info@clubmaster.org',
      'user[profile][profile_phone][phone_number]' => '80808080'
    ));
    $form['user[password][Password]'] = '1234';
    $form['user[password][Password_again]'] = '1234';

    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();

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
}
