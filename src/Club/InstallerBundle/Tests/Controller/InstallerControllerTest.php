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
    $form['administrator_step[profile][first_name]'] = 'John';
    $form['administrator_step[profile][last_name]'] = 'Doe';
    $form['administrator_step[profile][gender]'] = 'male';
    $form['administrator_step[profile][day_of_birth][day]'] = '29';
    $form['administrator_step[profile][day_of_birth][month]'] = '6';
    $form['administrator_step[profile][day_of_birth][year]'] = '1984';
    $form['administrator_step[language]'] = '1';
    $form['administrator_step[password][Password]'] = '1';
    $form['administrator_step[password][Password again]'] = '1';
    $form['administrator_step[profile][profile_email][email_address]'] = 'user@example.com';
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
    $crawler = $client->followRedirect();

    $form = $crawler->selectButton('Save')->form();
    $form['location_step[location_name]'] = 'Example';
    $form['location_step[currency]'] = '1';
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
