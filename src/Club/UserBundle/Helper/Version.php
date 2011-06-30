<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta3-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
