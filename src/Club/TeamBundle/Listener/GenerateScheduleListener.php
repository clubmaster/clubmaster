<?php

namespace Club\TeamBundle\Listener;

class GenerateScheduleListener
{
  private $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onRepetitionChange(\Club\TeamBundle\Event\FilterRepetitionEvent $event)
  {
    die('MARM');
  }
}
