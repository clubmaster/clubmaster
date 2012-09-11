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

  public function onMatchNew(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $this->processMatch($match);
  }

  public function onMatchTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $matches = $this->em->getRepository('ClubMatchBundle:Match')->getUnprocessed();

    foreach ($matches as $match) {
      $this->processMatch($match);
    }
  }

  private function processMatch(\Club\MatchBundle\Entity\Match $match)
  {
    if ($match->getLeague()) $this->club_league->addPoint($match);

    $match->setProcessed(1);
    $this->em->persist($match);
    $this->em->flush();
  }
}
