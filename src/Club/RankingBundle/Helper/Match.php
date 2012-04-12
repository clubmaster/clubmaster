<?php

namespace Club\RankingBundle\Helper;

class Match
{
  protected $em;
  protected $match;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function buildMatch(\Club\RankingBundle\Entity\Game $game, $data)
  {
    $teams = 2;

    $match = new \Club\RankingBundle\Entity\Match();
    $match->setGame($game);

    $display = array();
    for ($i = 0; $i < $teams; $i++) {
      $user = $this->em->find('ClubUserBundle:User', $data['user'.$i.'_id']);

      $team = $this->addTeam($match, $user);

      for ($j = 0; $j < $game->getGameSet(); $j++) {
        $set_str = 'user'.$i.'set'.$j;

        if (strlen($data[$set_str])) {
          if (!isset($display[$i])) $display[$i] = array();
          $display[$i][$j] = $data[$set_str];

          $this->addSet($team, $j+1, $data[$set_str]);
        }
      }
    }

    $str = $this->buildResultString($display);
    $winner = $this->findWinner($display);

    $match->setDisplayResult($str);

    $this->em->persist($match);
    $this->em->flush();

    $this->setMatch($match);
  }

  private function findWinner(array $display)
  {
    $res = array();
    $ret = '';
    for ($i = 0; $i < count($display[0]); $i++) {
      $ret .= $display[0][$i].'/'.$display[1][$i].' ';
    }

    return trim($ret);
  }

  private function buildResultString(array $display)
  {
    $ret = '';

    for ($i = 0; $i < count($display[0]); $i++) {
      $ret .= $display[0][$i].'/'.$display[1][$i].' ';
    }

    return trim($ret);
  }

  private function addTeam(\Club\RankingBundle\Entity\Match $match, \Club\UserBundle\Entity\User $user)
  {
    $team = new \Club\RankingBundle\Entity\MatchTeam();
    $team->setMatch($match);
    $team_user = new \Club\RankingBundle\Entity\MatchTeamUser();
    $team_user->setUser($user);
    $team_user->setMatchTeam($team);
    $team->addMatchTeamUser($team_user);
    $match->addMatchTeam($team);

    return $team;
  }

  private function addSet(\Club\RankingBundle\Entity\MatchTeam $team, $game_set, $value)
  {
    $set = new \Club\RankingBundle\Entity\MatchTeamSet();
    $set->setMatchTeam($team);
    $set->setGameSet($game_set);
    $set->setValue($value);
    $team->addMatchTeamSet($set);

    return $set;
  }

  public function setMatch(\Club\RankingBundle\Entity\Match $match)
  {
    $this->match = $match;
  }

  public function getMatch()
  {
    return $this->match;
  }
}
