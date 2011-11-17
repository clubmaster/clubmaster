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

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getNotProcessed();

    foreach ($schedules as $schedule) {
      foreach ($schedule->getUsers() as $user) {

        $last = clone $schedule->getFirstDate();
        $diff = new \DateInterval('PT'.$this->minutes_before_schedule.'M');
        $first = clone $schedule->getFirstDate()->sub($diff);

        $participant = $this->em->getRepository('ClubTeamBundle:Participant')->getUserInRange($user, $first, $last);
        if (!count($participant)) {
          // create penalty
        }
      }
    }
  }
}
