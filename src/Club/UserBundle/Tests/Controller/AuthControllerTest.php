<?php
namespace Club\UserBundle\Tests\Controller;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AuthControllerTest extends WebTestCase
{
  public function testForgot()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/en/auth/forgot');
    $this->assertEquals(200, $client->getResponse()->getStatusCode());

    $form = $crawler->selectButton('Send password')->form(array(
      'form[username]' => '2',
    ));
    $crawler = $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
