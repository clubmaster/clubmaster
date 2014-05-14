<?php

namespace Club\UserBundle\Helper;

class Version
{
    protected $version = '1.3.4-dev';

    public function getVersion()
    {
        return $this->version;
    }
}
