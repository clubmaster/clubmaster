<?php

namespace Club\TeamBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterScheduleEvent extends Event
{
  protected $schedule;

  public function __construct(\Club\TeamBundle\Entity\Schedule $schedule)
  {
    $this->schedule = $schedule;
  }

  public function getSchedule() {
    return $this->schedule;
  }
}
