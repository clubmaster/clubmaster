<?php

namespace Club\InstallerBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterVersionEvent extends Event
{
    protected $version;

    public function __construct(\Club\InstallerBundle\Entity\MigrationVersion $version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }
}
