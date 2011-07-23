<?php

namespace Club\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterForgotPasswordEvent extends Event
{
  private $forgot_password;

  public function __construct(\Club\UserBundle\Entity\ForgotPassword $forgot_password)
  {
    $this->forgot_password = $forgot_password;
  }

  public function getForgotPassword()
  {
    return $this->forgot_password;
  }
}
