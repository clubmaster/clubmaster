<?php

namespace Club\TournamentBundle\Helper;

class Tournament
{
  private $users = array();
  private $users_seed = array();
  private $working_users = array();
  private $seeds;
  private $bracket = array();
  private $round_number = 1;
  private $seed_number = 0;
  private $seed_odd = false;

  public function shuffleUsers()
  {
    shuffle($this->users);
  }

  public function setSeeds($seeds)
  {
    $this->seeds = $seeds;
    for ($i = 0; $i < $seeds; $i++) {
      $r = array_shift($this->users);
      array_push($this->users_seed, $r);
    }
  }

  public function setUsers(array $users)
  {
    $this->users = $users;
  }

  public function getBracket()
  {
    $this->working_users = array_merge($this->users_seed, $this->users);

    $n = count($this->working_users);
    // In round 1, there are $r1 competitors. The number of competitors must match 2^x, where x is a whole number.
    $r1 = pow(2, floor(log($n, 2)));
    // ...this leaves $r0 competitors, who must compete in the play-in round, round 0.
    $r0 = $n - $r1;

    if ($r0 > 0) {
      $round = $this->getNewRound();
      for ($i = 0; $i < $r0; $i++) {
        $round = $this->addPlayers($round, 2);
      }
      $round = $this->addBlank($round);
      $this->merge($round);
    }

    $round = $this->getNewRound();
    while ($this->seed_number*2 < count($this->working_users)) {

      $prev = count($round['matches'])*2;
      if (isset($this->bracket[0]['matches'][$prev][1]) && isset($this->bracket[0]['matches'][$prev+1][1])) {
        $round = $this->addPlayers($round, 0);
      } elseif (isset($this->bracket[0]['matches'][$prev][1])) {
        $round = $this->addPlayers($round, 1);
      } else {
        if (count($this->working_users) == 1) {
          $round = $this->addPlayers($round, 1);
        } else {
          $round = $this->addPlayers($round, 2);
        }
      }
    }
    $this->merge($round);

    $end_bracket = end($this->bracket);
    for ($r = 1, $n = count($end_bracket['matches']); $n > 1; $r++, $n /= 2) {

      $round = $this->getNewRound();
      for ($i = 0; $i < $n/2; $i++) {
        $round = $this->addPlayers($round, 0);
      }

      $this->merge($round);
    }

    array_push($this->bracket, array(
      'name' => 'Champion',
      'round' => count($this->bracket)+1,
      'winner' => array( 'name' => null )
    ));

    return $this->bracket;
  }

  private function getNewRound()
  {
    return array(
      'round' => $this->round_number,
      'name' => 'Round '.$this->round_number,
      'matches' => array()
    );
  }

  private function addPlayers($round, $amount)
  {
    switch ($amount) {
    case 0:
      array_push($round['matches'], array(
        array( 'name' => null, 'result' => null ),
        array( 'name' => null, 'result' => null )
      ));

      break;
    case 1:
      array_push($round['matches'], array(
        array( 'name' => null, 'result' => null ),
        array( 'name' => array_shift($this->working_users), 'result' => null )
      ));

      break;
    case 2:
      if (!$this->seed_odd) {
        $id1 = $this->seed_number;
        $id2 = count($this->working_users)-1-$this->seed_number;
        $this->seed_number++;
        $this->seed_odd = true;
      } else {
        $id1 = $this->seed_number;
        $id2 = count($this->working_users)-1-$this->seed_number;
        $this->seed_odd = false;

      }
      var_dump($id1);

      array_push($round['matches'], array(
        array( 'name' => $this->working_users[$id1], 'result' => null ),
        array( 'name' => $this->working_users[$id2], 'result' => null )
      ));

      break;
    }

    return $round;
  }

  private function merge($round)
  {
    array_push($this->bracket, $round);
    $this->round_number++;
  }

  private function addBlank($round)
  {
    array_push($round['matches'], array('blank' => true));
    return $round;
  }
}
