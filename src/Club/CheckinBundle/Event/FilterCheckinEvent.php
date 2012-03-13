<?php

namespace Club\CheckinBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterCheckinEvent extends Event
{
  protected $checkin;

  public function __construct(\Club\CheckinBundle\Entity\Checkin $checkin)
  {
    $this->checkin = $checkin;
  }

  public function getCheckin() {
    return $this->checkin;
  }
}
