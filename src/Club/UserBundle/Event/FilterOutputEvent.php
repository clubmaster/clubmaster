<?php

namespace Club\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterOutputEvent extends Event
{
  protected $output;
  protected $user;

  public function setOutput($output)
  {
    $this->output = $output;
  }

  public function getOutput()
  {
    return $this->output;
  }

  public function setUser($user)
  {
    $this->user = $user;
  }

  public function getUser()
  {
    return $this->user;
  }

}
