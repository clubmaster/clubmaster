<?php

namespace Club\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterUserEvent extends Event
{
  protected $user;

  public function __construct(\Club\UserBundle\Entity\User $user, \Club\UserBundle\Entity\ForgotPassword $forgot_password)
  {
    $this->user = $user;
    $this->forgot_password = $forgot_password;
  }

  public function getUser()
  {
    return $this->user;
  }

  public function getForgotPassword()
  {
    return $this->forgot_password;
  }
}
