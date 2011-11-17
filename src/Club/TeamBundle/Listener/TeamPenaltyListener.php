<?php

namespace Club\TeamBundle\Listener;

class TeamPenaltyListener
{
  private $em;
  private $minutes_before_schedule;
  private $penalty_enabled;

  public function __construct($em, $minutes_before_schedule, $penalty_enabled)
  {
    $this->em = $em;
    $this->minutes_before_schedule = $minutes_before_schedule;
    $this->penalty_enabled = $penalty_enabled;
  }

  public function onTeamPenalty(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    if (!$this->penalty_enabled)
      return;
  }
}
