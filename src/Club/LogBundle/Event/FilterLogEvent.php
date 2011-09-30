<?php

namespace Club\LogBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterLogEvent extends Event
{
  protected $message;

  public function __construct($message)
  {
    $this->message = $message;
  }

  public function getMessage()
  {
    return $this->message;
  }
}
