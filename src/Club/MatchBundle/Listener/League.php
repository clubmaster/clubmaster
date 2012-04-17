<?php

namespace Club\MatchBundle\Listener;

class League
{
  private $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onMatchTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $matches = $this->em->getRepository('ClubMatchBundle:Match')->getUnprocessed();

    foreach ($matches as $match) {
      $stats = $match->getMatchStats();
    }
    die();
  }
}
