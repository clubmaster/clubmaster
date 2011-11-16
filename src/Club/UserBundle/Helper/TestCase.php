<?php

namespace Club\UserBundle\Helper;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestCase extends WebTestCase
{
  protected function apiLogin()
  {
    $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => '10',
      'PHP_AUTH_PW' => '1234'
    ));

    return $client;
  }

  protected function apiKey()
  {
    $client = static::createClient(array(), array(
      'API_KEY' => 'THIS_IS_A_DEMO_KEY'
    ));

    return $client;
  }

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
