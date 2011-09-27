<?php
namespace Club\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
  public function testIndex()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/auth/register');
    $this->assertTrue($crawler->filter('html:contains("Personal Information")')->count() > 0);
  }
}
