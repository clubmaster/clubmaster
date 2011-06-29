<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'RC1-DEV';

  public function getVersion()
  {
    return $this->version;
  }
}
