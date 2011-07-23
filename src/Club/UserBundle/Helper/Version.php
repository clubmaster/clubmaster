<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta9';

  public function getVersion()
  {
    return $this->version;
  }
}
