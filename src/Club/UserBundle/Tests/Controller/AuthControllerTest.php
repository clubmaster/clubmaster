<?php
namespace Club\UserBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

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

    $form = $crawler->selectButton('Save')->form(array(
      'user[profile][first_name]' => 'John',
      'user[profile][last_name]' => 'Doe',
      'user[profile][profile_address][street]' => 'Myllerstrasse 14',
      'user[profile][profile_address][postal_code]' => '9000',
      'user[profile][profile_address][city]' => 'Aalborg',
      'user[profile][profile_email][email_address]' => 'user@example.com',
      'user[profile][profile_phone][number]' => '80808080'
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
