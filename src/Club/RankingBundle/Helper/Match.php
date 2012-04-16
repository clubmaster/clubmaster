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
      $r = array();
      if ($data['user'.$i.'_id'] != '') {
        $r['id'] = $data['user'.$i.'_id'];
      } else {
        $r['query'] = $data['user'.$i];
      }

      try {
        $user = $this->em->getRepository('ClubUserBundle:User')->getOneBySearch($r);
      } catch (\Doctrine\ORM\NonUniqueResultException $e) {
        $this->setError($this->translator->trans('Too many users match this search'));
        return;
      }
      if (!$user) {
          $this->setError($this->translator->trans('No such user'));
          return;
      }

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

    if (!$this->validateSets($display)) {
      $this->setError($this->translator->trans('You have not played enough set'));
      return;
    }

    $str = $this->buildResultString($display);
    $this->match->setDisplayResult($str);

    $winner = $this->findWinner($display);
    $this->match->setWinner($winner);
  }

  public function save()
  {
    $this->em->persist($this->match);
    $this->em->flush();
  }

  private function validateSets($display)
  {
    for ($i = 0; $i < 2; $i++) {
      $sets = count($display[$i]);
      if ($sets < ($this->match->getGame()->getGameSet()/2))
        return false;
    }

    return true;
  }

  private function findWinner($display)
  {
    $won = array(
      0 => 0,
      1 => 0
    );

    for ($i = 0; $i < count($display[0]); $i++) {
      if ($display[0][$i] > $display[1][$i]) {
        $won[0]++;
      } else {
        $won[1]++;
      }
    }

    $teams = $this->match->getMatchTeams();

    if ($won[0] == $won[1]) {
      return false;
    } elseif ($won[0] > $won[1]) {
      $team = $teams[0];
    } else {
      $team = $teams[1];
    }

    return $team;
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
