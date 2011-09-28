<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'rc3-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
