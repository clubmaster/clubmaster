<?php

namespace Club\BookingBundle\Listener;

class Migrate
{
    private $container;
    private $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
    }

    public function onVersionMigrate(\Club\InstallerBundle\Event\FilterVersionEvent $event)
    {
    }
}
