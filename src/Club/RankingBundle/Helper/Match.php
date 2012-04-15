<?php

namespace Club\RankingBundle\Helper;

class Match
{
  protected $em;
  protected $translator;
  protected $match;
  protected $error;
  protected $is_valid = true;

  public function __construct($em, $translator)
  {
    $this->em = $em;
    $this->translator = $translator;
  }

  public function bindMatch(\Club\RankingBundle\Entity\Game $game, $data)
  {
    $teams = 2;

    $this->match = new \Club\RankingBundle\Entity\Match();
    $this->match->setGame($game);

    $display = array();
    for ($i = 0; $i < $teams; $i++) {
      $user = $this->em->find('ClubUserBundle:User', $data['user'.$i.'_id']);

      if ($game->getInviteOnly()) {
        if (!$game->canPlay($user)) {
          $this->setError($this->translator->trans('%user% is not allowed to play in this game.', array(
            '%user%' => $user->getName()
          )));
          return;
        }
      }

      $team = $this->addTeam($user);

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

    $this->match->setDisplayResult($str);
  }

  public function save()
  {
    $this->em->persist($this->match);
    $this->em->flush();
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

  private function addTeam(\Club\UserBundle\Entity\User $user)
  {
    $team = new \Club\RankingBundle\Entity\MatchTeam();
    $team->setMatch($this->match);
    $team_user = new \Club\RankingBundle\Entity\MatchTeamUser();
    $team_user->setUser($user);
    $team_user->setMatchTeam($team);
    $team->addMatchTeamUser($team_user);
    $this->match->addMatchTeam($team);

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

  public function setError($error)
  {
    $this->error = $error;
    $this->is_valid = false;
  }

  public function getError()
  {
    return $this->error;
  }

  public function isValid()
  {
    return $this->is_valid;
  }
}
