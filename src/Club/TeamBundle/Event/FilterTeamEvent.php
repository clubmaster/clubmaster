<?php

namespace Club\TeamBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterTeamEvent extends Event
{
  protected $team;
  protected $user;

  public function __construct(\Club\TeamBundle\Entity\Team $team, \Club\UserBundle\Entity\User $user)
  {
    $this->team = $team;
    $this->user = $user;
  }

  public function getTeam()
  {
    return $this->team;
  }

  public function getUser()
  {
    return $this->user;
  }
}
