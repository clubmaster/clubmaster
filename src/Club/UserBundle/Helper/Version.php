<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta6-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
