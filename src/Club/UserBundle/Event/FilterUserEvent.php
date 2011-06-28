<?php

namespace Club\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterUserEvent extends Event
{
  protected $user;

  public function __construct(\Club\UserBundle\Entity\User $user)
  {
    $this->user = $user;
  }

  public function getUser()
  {
    return $this->user;
  }
}
