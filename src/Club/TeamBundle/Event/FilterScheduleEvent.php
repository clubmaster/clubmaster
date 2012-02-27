<?php

namespace Club\TeamBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterScheduleEvent extends Event
{
  protected $schedule;
  protected $user;

  public function __construct(\Club\TeamBundle\Entity\Schedule $schedule, \Club\UserBundle\Entity\User $user)
  {
    $this->schedule = $schedule;
    $this->user = $user;
  }

  public function getSchedule()
  {
    return $this->schedule;
  }

  public function getUser()
  {
    return $this->user;
  }
}
