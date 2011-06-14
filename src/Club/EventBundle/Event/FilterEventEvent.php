<?php

namespace Club\EventBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterEventEvent extends Event
{
  protected $event;

  public function __construct(\Club\EventBundle\Entity\Event $event)
  {
    $this->event = $event;
  }

  public function getEvent() {
    return $this->event;
  }
}
