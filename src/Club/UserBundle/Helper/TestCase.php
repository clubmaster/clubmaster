<?php

namespace Club\UserBundle\Helper;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestCase extends WebTestCase
{
  protected function login($client)
  {
    $crawler = $client->request('GET', '/login');
    $form = $crawler->selectButton('Sign In')->form(array(
      '_username' => '10',
      '_password' => '1234'
    ));
    $crawler = $client->submit($form);

    return $client;
  }
}
