<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = 'beta1';

  public function getVersion()
  {
    return $this->version;
  }
}
