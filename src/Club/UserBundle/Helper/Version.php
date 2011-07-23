<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta8';

  public function getVersion()
  {
    return $this->version;
  }
}
