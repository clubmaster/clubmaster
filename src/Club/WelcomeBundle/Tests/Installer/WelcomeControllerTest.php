<?php

namespace Club\WelcomeBundle\Tests\Installer;

use Club\UserBundle\Helper\TestCase as WebTestCase;

class WelcomeControllerTest extends WebTestCase
{
    public function __construct()
    {
        $this->client = static::createClient();
        $this->login($this->client);
    }

    public function testEdit()
    {
        $crawler = $this->client->request('GET', '/en/admin/welcome/edit/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Save')->form(array(
            'welcome[content]' => <<<EOF
<h3>In order to see the demo of the site, please visit:</h3>

    <p><strong>Admin login:</strong><br>
    Username: 1<br>
    Password: 1234</p>

    <p><strong>User login:</strong><br>
    Username: 10<br>
    Password: 1234</p>

    <p>You are free to do whatever you like, and what we really want is some feedback.</p>
EOF
        ));
        $crawler = $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
