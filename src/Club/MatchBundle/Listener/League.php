<?php

namespace Club\MatchBundle\Listener;

class League
{
  private $em;
  private $club_league;

  public function __construct($em, $club_league)
  {
    $this->em = $em;
    $this->club_league = $club_league;
  }

  public function onMatchTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $matches = $this->em->getRepository('ClubMatchBundle:Match')->getUnprocessed();

    foreach ($matches as $match) {
      $this->club_league->addPoint($match);

      $match->setProcessed(1);
      $this->em->persist($match);
      $this->em->flush();
    }
  }
}
