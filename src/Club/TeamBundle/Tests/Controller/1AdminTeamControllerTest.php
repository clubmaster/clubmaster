<?php
namespace Club\TeamBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminTeamControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/admin/team/team/1/team');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $crawler = $this->client->request('GET', '/admin/team/team/1/team/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $time = strtotime('+1 day');
    $form = $crawler->selectButton('Save')->form(array(
      'team[first_date][date][day]' => date('j', $time),
      'team[first_date][date][month]' => date('n', $time),
      'team[first_date][date][year]' => date('Y', $time),
      'team[end_date][date][day]' => date('j', $time),
      'team[end_date][date][month]' => date('n', $time),
      'team[end_date][date][year]' => date('Y', $time)
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testRepetition()
  {
    $crawler = $this->client->request('GET', '/admin/team/team/1/team/1/repetition');
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    $crawler = $this->client->followRedirect();

    $form = $crawler->selectButton('Save')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
