<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = '1.0-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
