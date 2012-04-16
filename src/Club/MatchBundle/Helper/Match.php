<?php

namespace Club\MatchBundle\Helper;

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

  public function bindMatch(\Club\MatchBundle\Entity\League $league, $data)
  {
    $teams = 2;

    $this->match = new \Club\MatchBundle\Entity\Match();
    $this->match->setLeague($league);

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

      if ($league->getInviteOnly()) {
        if (!$league->canPlay($user)) {
          $this->setError($this->translator->trans('%user% is not allowed to play in this league.', array(
            '%user%' => $user->getName()
          )));
          return;
        }
      }

      $team = $this->getTeam($user);
      $match_team = $this->addTeam($team);

      for ($j = 0; $j < $league->getGameSet(); $j++) {
        $set_str = 'user'.$i.'set'.$j;

        if (strlen($data[$set_str])) {
          if (!isset($display[$i])) $display[$i] = array();
          $display[$i][$j] = $data[$set_str];

          $this->addSet($match_team, $j+1, $data[$set_str]);
        }
      }
    }

    if (!$this->validateSets($display)) {
      return;
    }

    if (!$this->validateRules()) {
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

  private function validateRules()
  {
    $qb = $this->em->createQueryBuilder()
      ->select('count(mt.team)')
      ->from('ClubMatchBundle:MatchTeam', 'mt')
      ->leftJoin('mt.match', 'm')
      ->where('m.league = :league')
      ->andWhere('mt.team = ?1 OR mt.team = ?2')
      ->groupBy('mt.match')
      ->having('count(mt.team) = 2')
      ->setParameter('league', $this->match->getLeague()->getId());

    $i = 0;
    foreach ($this->match->getMatchTeams() as $match_team) {
      $i++;
      $qb
        ->setParameter($i, $match_team->getTeam()->getId());
    }

    $matches = $qb
      ->getQuery()
      ->getResult();

    $total = $this->match->getLeague()->getRule()->getMatchSamePlayer();

    if (count($matches) >= $total) {
      $this->setError($this->translator->trans('Teams has already played %count% matches against each other.', array(
        '%count%' => count($matches)
      )));
      return false;
    }

    return true;
  }

  private function validateSets($display)
  {
    if (!count($display)) {
      $this->setError($this->translator->trans('You have not played enough set'));
      return;
    }

    foreach ($display as $team) {
      $i = 0;
      foreach ($team as $set => $data) {
        $i++;
        if ($set+1 != $i) {
          $this->setError($this->translator->trans('You has to enter set in the right order.'));
          return;
        }
      }
    }

    foreach ($display[0] as $set => $data) {
      $set1 = $display[0][$set];
      $set2 = $display[1][$set];

      if ($set1 < 6 && $set2 < 6) {
        $this->setError($this->translator->trans('The match result is not valid.'));
        return;
      }

    }

    if (count($display[0]) < ($this->match->getLeague()->getGameSet()/2) || count($display[1]) < ($this->match->getLeague()->getGameSet()/2)) {
      $this->setError($this->translator->trans('You have not played enough set'));
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

  private function getTeam(\Club\UserBundle\Entity\User $user)
  {
    $team = $this->em->getRepository('ClubMatchBundle:Team')->getTeamByUser($user);
    if (!$team) {
      $team = new \Club\MatchBundle\Entity\Team();
      $team->addUser($user);

      $this->em->persist($team);
    }

    return $team;
  }

  private function addTeam(\Club\MatchBundle\Entity\Team $team)
  {
    $match_team = new \Club\MatchBundle\Entity\MatchTeam();
    $match_team->setMatch($this->match);
    $match_team->setTeam($team);
    $this->match->addMatchTeam($match_team);

    return $match_team;
  }

  private function addSet(\Club\MatchBundle\Entity\MatchTeam $team, $game_set, $value)
  {
    $set = new \Club\MatchBundle\Entity\MatchTeamSet();
    $set->setMatchTeam($team);
    $set->setGameSet($game_set);
    $set->setValue($value);
    $team->addMatchTeamSet($set);

    return $set;
  }

  public function setMatch(\Club\MatchBundle\Entity\Match $match)
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
