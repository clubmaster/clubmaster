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
      foreach ($match->getMatchTeams() as $match_team) {

        $lt = $this->em->getRepository('ClubMatchBundle:LeagueTable')->getUser($match_team);

        if ($match_team == $match->getWinner()) {
          $lt->setPlayed($lt->getPlayed()+1);
          $lt->setWin($lt->getWin()+1);
          $lt->setPoint($lt->getPoint()+$match->getLeague()->getRule()->getPointWon());

        } else {
          $lt->setPlayed($lt->getPlayed()+1);
          $lt->setLoss($lt->getLoss()+1);
          $lt->setPoint($lt->getPoint()+$match->getLeague()->getRule()->getPointLoss());

        }

        $this->em->persist($lt);
      }

      $match->setProcessed(1);
      $this->em->persist($match);
    }

    $this->em->flush();
  }
}
