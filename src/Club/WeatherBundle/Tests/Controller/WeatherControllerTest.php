<?php

namespace Club\WeatherBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/en/weather');
        $this->assertTrue($crawler->filter('html:contains("Weather right now!")')->count() > 0);
    }
}
