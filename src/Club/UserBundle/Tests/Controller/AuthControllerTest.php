<?php
namespace Club\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
  public function testRegister()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/auth/register');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $client->submit($form);
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form['user[profile][first_name]'] = 'John';
    $form['user[profile][last_name]'] = 'Doe';
    $form['user[profile][profile_address][street]'] = 'Myllerstrasse 14';
    $form['user[profile][profile_address][postal_code]'] = '9000';
    $form['user[profile][profile_address][city]'] = 'Aalborg';
    $form['user[profile][profile_email][email_address]'] = 'user@example.com';
    $form['user[profile][profile_phone][number]'] = '80808080';

    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
