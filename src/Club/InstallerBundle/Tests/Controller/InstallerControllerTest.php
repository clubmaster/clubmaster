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

    $link = $crawler->selectLink('Start installation')->link();
    $crawler = $client->click($link);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $link = $crawler->selectLink('Install database')->link();
    $crawler = $client->click($link);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
    $crawler = $client->followRedirect();

    $form = $crawler->selectButton('Save')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'administrator_step[profile][first_name]' => 'John',
      'administrator_step[profile][last_name]' => 'Doe',
      'administrator_step[profile][gender]' => 'male',
      'administrator_step[profile][day_of_birth]' => '1984-06-29',
      'administrator_step[password][Password]' => '1234',
      'administrator_step[password][Password_again]' => '1234',
      'administrator_step[profile][profile_emails][0][email_address]' => 'info@clubmaster.org'
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

  public function testUpdate()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/login');
    $form = $crawler->selectButton('Sign In')->form(array(
      '_username' => '1',
      '_password' => '1234'
    ));
    $crawler = $client->submit($form);

    $crawler = $client->request('GET', '/en/user');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'user[profile][profile_address][street]' => 'Oesterbro 62, 2tv',
      'user[profile][profile_address][postal_code]' => '9000',
      'user[profile][profile_address][city]' => 'Aalborg',
      'user[profile][profile_address][country]' => 'DK',
      'user[profile][profile_phone][phone_number]' => '80808080'
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
