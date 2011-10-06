<?php
namespace Club\AccountBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminLedgerControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient();
    $this->login($client);

    $crawler = $client->request('GET', '/admin/account/ledger/1');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
