<?php
namespace Club\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminCurrencyControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => '10',
      'PHP_AUTH_PW' => '1234'
    ));
    $crawler = $client->request('GET', '/admin/currency');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => '10',
      'PHP_AUTH_PW' => '1234'
    ));
    $crawler = $client->request('GET', '/admin/currency/new');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'currency[currency_name]' => 'Test',
      'currency[code]' => 'us_UK',
      'currency[symbol_left]' => '',
      'currency[symbol_right]' => ',-',
      'currency[decimal_places]' => '1',
      'currency[value]' => '1',
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
