<?php

namespace Club\BookingBundle\Tests\Installer;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class AdminBookingControllerTest extends WebTestCase
{
    protected $client;

    public function __construct()
    {
        $this->client = static::createClient();
        $this->login($this->client);
    }

    public function testNew()
    {
        for ($i = 1; $i < 7; $i++) {
            $crawler = $this->client->request('GET', '/en/admin/booking/field/new');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $form = $crawler->selectButton('Save')->form();
            $crawler = $this->client->submit($form);
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

            $form = $crawler->selectButton('Save')->form(array(
                'admin_field[name]' => 'Field '.$i
            ));
            $crawler = $this->client->submit($form);
            $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
            $crawler = $this->client->followRedirect();

            $form = $crawler->selectButton('Save')->form();
            $crawler = $this->client->submit($form);
            $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        }
    }
}
