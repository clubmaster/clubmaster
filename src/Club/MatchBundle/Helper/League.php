<?php

namespace Club\MatchBundle\Helper;

class League
{
  protected $em;
  protected $translator;

  public function __construct($em, $translator)
  {
    $this->em = $em;
    $this->translator = $translator;
  }

  public function addPoint(\Club\MatchBundle\Entity\Match $match)
  {
    foreach ($match->getMatchTeams() as $match_team) {

      $lt = $this->em->getRepository('ClubMatchBundle:LeagueTable')->getTeam($match_team->getMatch()->getLeague(), $match_team->getTeam());

      if ($match_team == $match->getWinner()) {
        $lt->setPlayed($lt->getPlayed()+1);
        $lt->setWon($lt->getWon()+1);
        $lt->setPoint($lt->getPoint()+$match->getLeague()->getRule()->getPointWon());

      } else {
        $lt->setPlayed($lt->getPlayed()+1);
        $lt->setLost($lt->getLost()+1);
        $lt->setPoint($lt->getPoint()+$match->getLeague()->getRule()->getPointLost());

      }

      $this->em->persist($lt);
    }
  }

  public function revokePoint(\Club\MatchBundle\Entity\Match $match)
  {
    foreach ($match->getMatchTeams() as $match_team) {

      $lt = $this->em->getRepository('ClubMatchBundle:LeagueTable')->getTeam($match_team->getMatch()->getLeague(), $match_team->getTeam());

      if ($match_team == $match->getWinner()) {
        $lt->setPlayed($lt->getPlayed()-1);
        $lt->setWon($lt->getWon()-1);
        $lt->setPoint($lt->getPoint()-$match->getLeague()->getRule()->getPointWon());

      } else {
        $lt->setPlayed($lt->getPlayed()-1);
        $lt->setLost($lt->getLost()-1);

        if ($lt->getPoint() > 0)
          $lt->setPoint($lt->getPoint()-$match->getLeague()->getRule()->getPointLost());

      }

      $this->em->persist($lt);
    }
  }
}
