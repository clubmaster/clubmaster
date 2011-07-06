<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta4-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
