<?php

namespace Club\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterGroupEvent extends Event
{
  protected $group;

  public function __construct(\Club\UserBundle\Entity\Group $group)
  {
    $this->group = $group;
  }

  public function getGroup()
  {
    return $this->group;
  }
}
