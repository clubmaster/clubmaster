<?php
namespace Club\TeamBundle\Tests\Controller;

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
    $crawler = $this->client->request('GET', '/admin/team/team/1/schedule');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $crawler = $this->client->request('GET', '/admin/team/team/1/schedule/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $time = strtotime('+1 day');
    $form = $crawler->selectButton('Save')->form(array(
      'schedule[first_date][date][day]' => date('j', $time),
      'schedule[first_date][date][month]' => date('n', $time),
      'schedule[first_date][date][year]' => date('Y', $time),
      'schedule[end_date][date][day]' => date('j', $time),
      'schedule[end_date][date][month]' => date('n', $time),
      'schedule[end_date][date][year]' => date('Y', $time)
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
