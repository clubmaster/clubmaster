<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta7-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
