<?php

namespace Club\ShopBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterTeamEvent extends Event
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
