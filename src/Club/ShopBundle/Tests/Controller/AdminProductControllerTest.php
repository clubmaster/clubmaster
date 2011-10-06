<?php
namespace Club\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminProductControllerTest extends WebTestCase
{
  protected function login($client)
  {
    $crawler = $client->request('GET', '/login');
    $form = $crawler->selectButton('Sign In')->form();
    $form['_username'] = '10';
    $form['_password'] = '1234';
    $crawler = $client->submit($form);
  }

  public function testIndex()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/shop/product');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/shop/product/new');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'product[product_name]' => 'Test1234',
      'product[description]' => 'Testing',
      'product[price]' => '123'
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }

  public function testDelete()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/shop/product');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $links = $crawler->selectLink('Delete')->links();
    $crawler = $client->click(end($links));
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
