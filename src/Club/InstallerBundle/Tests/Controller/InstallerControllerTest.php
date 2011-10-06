<?php
namespace Club\InstallerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InstallerControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/installer');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Start installer')->link();
    $crawler = $client->click($link);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'administrator_step[profile][first_name]' => 'John',
      'administrator_step[profile][last_name]' => 'Doe',
      'administrator_step[profile][gender]' => 'male',
      'administrator_step[profile][day_of_birth][day]' => '29',
      'administrator_step[profile][day_of_birth][month]' => '6',
      'administrator_step[profile][day_of_birth][year]' => '1984',
      'administrator_step[language]' => '1',
      'administrator_step[password][Password]' => '1',
      'administrator_step[password][Password again]' => '1',
      'administrator_step[profile][profile_email][email_address]' => 'user@example.com'
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
    $crawler = $client->followRedirect();

    $form = $crawler->selectButton('Save')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'location_step[location_name]' => 'Example',
      'location_step[currency]' => '1'
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
