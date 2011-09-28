<?php
namespace Club\EventBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
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

    $crawler = $client->request('GET', '/event/event');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testical()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/event/ical');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
