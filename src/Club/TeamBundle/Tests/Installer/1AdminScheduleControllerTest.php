<?php
namespace Club\TeamBundle\Tests\Installer;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminScheduleControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/en/admin/team/team/1/schedule');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $crawler = $this->client->request('GET', '/en/admin/team/team/1/schedule/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $time = strtotime('+1 day');
    $form = $crawler->selectButton('Save')->form(array(
      'schedule[first_date][date]' => date('Y-m-d', $time),
      'schedule[end_date][date]' => date('Y-m-d', $time),
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testRepetition()
  {
    $crawler = $this->client->request('GET', '/en/admin/team/team/schedule/1/repetition');
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();

    $form = $crawler->selectButton('Save')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
