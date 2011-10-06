<?php
namespace Club\AccountBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminLedgerControllerTest extends WebTestCase
{
  protected $client;

  public function __construct()
  {
    $this->client = static::createClient();
    $this->login($this->client);
  }

  public function testIndex()
  {
    $crawler = $this->client->request('GET', '/admin/account/ledger/1');
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
  }
}
