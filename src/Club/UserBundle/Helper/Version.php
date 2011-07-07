<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta5-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
