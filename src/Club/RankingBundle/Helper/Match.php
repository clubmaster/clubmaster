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

      $team = $this->getTeam($user);
      $match_team = $this->addTeam($team);

      for ($j = 0; $j < $game->getGameSet(); $j++) {
        $set_str = 'user'.$i.'set'.$j;

        if (strlen($data[$set_str])) {
          if (!isset($display[$i])) $display[$i] = array();
          $display[$i][$j] = $data[$set_str];

          $this->addSet($match_team, $j+1, $data[$set_str]);
        }
      }
    }

    if (!$this->validateSets($display)) {
      $this->setError($this->translator->trans('You have not played enough set'));
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
      ->from('ClubRankingBundle:MatchTeam', 'mt')
      ->leftJoin('mt.match', 'm')
      ->where('m.game = :game')
      ->andWhere('mt.team = ?1 OR mt.team = ?2')
      ->groupBy('mt.match')
      ->having('count(mt.team) = 2')
      ->setParameter('game', $this->match->getGame()->getId());

    $i = 0;
    foreach ($this->match->getMatchTeams() as $match_team) {
      $i++;
      $qb
        ->setParameter($i, $match_team->getTeam()->getId());
    }

    $res = $qb
      ->getQuery()
      ->getResult();

    $matches = count($res);
    $total = $this->match->getGame()->getRule()->getMatchSamePlayer();

    if ($matches >= $total) {
      $this->setError($this->translator->trans('Teams has already played %count% matches against each other.', array(
        '%count%' => count($matches)
      )));
      return false;
    }

    return true;
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

  private function getTeam(\Club\UserBundle\Entity\User $user)
  {
    $team = $this->em->getRepository('ClubRankingBundle:Team')->getTeamByUser($user);
    if (!$team) {
      $team = new \Club\RankingBundle\Entity\Team();
      $team->addUser($user);

      $this->em->persist($team);
    }

    return $team;
  }

  private function addTeam(\Club\RankingBundle\Entity\Team $team)
  {
    $match_team = new \Club\RankingBundle\Entity\MatchTeam();
    $match_team->setMatch($this->match);
    $match_team->setTeam($team);
    $this->match->addMatchTeam($match_team);

    return $match_team;
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
