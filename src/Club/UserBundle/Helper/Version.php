<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'rc1';

  public function getVersion()
  {
    return $this->version;
  }
}
