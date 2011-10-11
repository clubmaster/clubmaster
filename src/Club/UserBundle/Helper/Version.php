<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'rc4-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
