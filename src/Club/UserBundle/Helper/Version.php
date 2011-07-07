<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta4';

  public function getVersion()
  {
    return $this->version;
  }
}
