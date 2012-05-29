<?php

namespace Club\MatchBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterMatchEvent extends Event
{
  protected $match;

  public function __construct(\Club\MatchBundle\Entity\Match $match)
  {
    $this->match = $match;
  }

  public function getMatch()
  {
    return $this->match;
  }
}
