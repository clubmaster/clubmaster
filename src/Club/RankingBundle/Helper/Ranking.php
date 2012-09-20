<?php

namespace Club\RankingBundle\Helper;

class Ranking
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

      $lt = $this->em->getRepository('ClubRankingBundle:RankingTable')->getTeam($match_team->getMatch()->getRanking(), $match_team->getTeam());

      if ($match_team == $match->getWinner()) {
        $lt->setPlayed($lt->getPlayed()+1);
        $lt->setWon($lt->getWon()+1);
        $lt->setPoint($lt->getPoint()+$match->getRanking()->getRule()->getPointWon());

      } else {
        $lt->setPlayed($lt->getPlayed()+1);
        $lt->setLost($lt->getLost()+1);
        $lt->setPoint($lt->getPoint()+$match->getRanking()->getRule()->getPointLost());

      }

      $this->em->persist($lt);
    }
  }

  public function revokePoint(\Club\MatchBundle\Entity\Match $match)
  {
    foreach ($match->getMatchTeams() as $match_team) {

      $lt = $this->em->getRepository('ClubRankingBundle:RankingTable')->getTeam($match_team->getMatch()->getRanking(), $match_team->getTeam());

      if ($match_team == $match->getWinner()) {
        $lt->setPlayed($lt->getPlayed()-1);
        $lt->setWon($lt->getWon()-1);
        $lt->setPoint($lt->getPoint()-$match->getRanking()->getRule()->getPointWon());

      } else {
        $lt->setPlayed($lt->getPlayed()-1);
        $lt->setLost($lt->getLost()-1);

        if ($lt->getPoint() > 0)
          $lt->setPoint($lt->getPoint()-$match->getRanking()->getRule()->getPointLost());

      }

      $this->em->persist($lt);
    }
  }
}
