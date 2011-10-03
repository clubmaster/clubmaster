<?php

namespace Club\LogBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterLogEvent extends Event
{
  protected $message;
  protected $type;
  protected $severity;

  public function __construct($message, $type, $event, $severity='critical')
  {
    $this->message = $message;
    $this->event = $event;
    $this->type = $type;
    $this->severity = $severity;
  }

  public function getMessage()
  {
    return $this->message;
  }

  public function getEvent()
  {
    return $this->event;
  }

  public function getType()
  {
    return $this->type;
  }

  public function getSeverity()
  {
    return $this->severity;
  }
}
