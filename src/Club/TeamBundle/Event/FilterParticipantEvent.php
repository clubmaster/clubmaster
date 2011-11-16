<?php

namespace Club\TeamBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterParticipantEvent extends Event
{
  protected $participant;

  public function __construct(\Club\TeamBundle\Entity\Participant $participant)
  {
    $this->participant = $participant;
  }

  public function getParticipant() {
    return $this->participant;
  }
}
