<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta6';

  public function getVersion()
  {
    return $this->version;
  }
}
