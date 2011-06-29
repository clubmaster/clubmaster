<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta2-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
