<?php

namespace Club\TeamBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterRepetitionEvent extends Event
{
  protected $repetition;

  public function __construct(\Club\TeamBundle\Entity\Repetition $repetition)
  {
    $this->repetition = $repetition;
  }

  public function getRepetition() {
    return $this->repetition;
  }
}
