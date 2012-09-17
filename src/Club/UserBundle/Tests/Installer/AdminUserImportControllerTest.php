<?php
namespace Club\UserBundle\Tests\Installer;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminUserImportControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/en/admin/user/import');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Import')->form(array(
      'form[user_file]' => $this->client->getKernel()->getRootDir().'/sql/users.csv',
      'form[skip_first_line]' => '1',
      'form[field_delimiter]' => 'comma'
    ));
    $crawler = $this->client->submit($form);
    $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
  }
}
