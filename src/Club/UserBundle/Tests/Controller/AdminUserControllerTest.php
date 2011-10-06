<?php
namespace Club\UserBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminUserControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/admin/user');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }

  public function testNew()
  {
    $crawler = $this->client->request('GET', '/admin/user/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form();
    $crawler = $this->client->submit($form);
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'admin_user[profile][first_name]' => 'John',
      'admin_user[profile][last_name]' => 'Doe',
      'admin_user[profile][profile_address][street]' => 'Clubby Strasse 14',
      'admin_user[profile][profile_address][postal_code]' => '9000',
      'admin_user[profile][profile_address][city]' => 'Aalborg',
      'admin_user[profile][profile_email][email_address]' => 'user@example.com',
      'admin_user[profile][profile_phone][number]' => '+45 80808080',
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

    $crawler = $this->client->request('GET', '/admin/user/new');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Save')->form(array(
      'admin_user[profile][first_name]' => 'John',
      'admin_user[profile][last_name]' => 'Doe',
      'admin_user[profile][profile_address][street]' => 'Clubby Strasse 14',
      'admin_user[profile][profile_address][postal_code]' => '9000',
      'admin_user[profile][profile_address][city]' => 'Aalborg',
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }

  public function testBan()
  {
    $crawler = $this->client->request('GET', '/admin/user');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $links = $crawler->selectLink('Ban')->links();
    $crawler = $this->client->click($links[1]);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
