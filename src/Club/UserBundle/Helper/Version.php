<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'rc2-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
