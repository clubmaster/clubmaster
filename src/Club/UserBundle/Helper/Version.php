<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta7';

  public function getVersion()
  {
    return $this->version;
  }
}
