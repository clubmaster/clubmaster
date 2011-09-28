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

  public function testICal()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/event/ical');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/event/event/new');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'event[event_name]' => 'Test',
      'event[description]' => 'Test'
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
