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
  private $seed_number = 1;
  private $rounds;
  private $round_count = 1;

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
    $this->rounds = pow(2, floor(log($n, 2)));
    if ($n - $this->rounds > 0) $this->rounds *= 2;

    $round = $this->getNewRound();
    while ($this->seed_number*2 <= $this->rounds) {
      $round = $this->addMatch($round);
    }
    $this->merge($round);

    $end_bracket = end($this->bracket);
    for ($r = 1, $n = count($end_bracket['matches']); $n > 1; $r++, $n /= 2) {

      $round = $this->getNewRound();
      for ($i = 0; $i < $n/2; $i++) {
        $round = $this->addMatch($round, false);
      }

      $this->merge($round);
    }

    array_push($this->bracket, array(
      'name' => null,
      'round' => count($this->bracket)+1,
      'winner' => array( 'name' => null )
    ));

    $this->fixUsers();
    $this->fixRoundNames();

    foreach ($this->bracket[0]['matches'] as $id => $match) {
      if (!strlen($match[0]['name'])) {
        $this->bracket[0]['matches'][$id] = $this->addBlank();
        $this->bracket[1]['matches'][$id/2][1]['name'] = $match[1]['name'];
      } elseif (!strlen($match[1]['name'])) {
        $this->bracket[0]['matches'][$id] = $this->addBlank();
        $this->bracket[1]['matches'][$id/2][0]['name'] = $match[0]['name'];
      }
    }

    return $this->bracket;
  }

  private function fixRoundNames()
  {
    foreach ($this->bracket as $i => $round) {
      switch ($this->round_number-$i) {
      case 1:
        $this->bracket[$i]['name'] = 'Champion';
        break;
      case 2:
        $this->bracket[$i]['name'] = 'Final';
        break;
      case 3:
        $this->bracket[$i]['name'] = 'Semi-finals';
        break;
      case 4:
        $this->bracket[$i]['name'] = 'Quarter-finals';
        break;
      }
    }
  }

  private function fixUsers()
  {
    foreach ($this->working_users as $seed => $user) {
      foreach ($this->bracket[0]['matches'] as $match_id => $match) {
        foreach ($match as $row_id => $row) {
          if ($row['seed']-1 == $seed) {
            $this->bracket[0]['matches'][$match_id][$row_id]['name'] = $user;
          }
        }
      }
    }
  }

  private function getNewRound()
  {
    return array(
      'round' => $this->round_number,
      'name' => 'Round '.$this->round_number,
      'matches' => array()
    );
  }

  private function addMatch($round, $add_seed=true)
  {
    if ($add_seed) {
      switch ($this->seed_number) {
      case 1: $id1 = $this->rounds/1*1; break;
      case 2: $id1 = $this->rounds/2*1; break;
      case 3: $id1 = $this->rounds/4*3; break;
      case 4: $id1 = $this->rounds/4*1; break;
      case 5: $id1 = $this->rounds/8*3; break;
      case 6: $id1 = $this->rounds/8*7; break;
      case 7: $id1 = $this->rounds/8*5; break;
      case 8: $id1 = $this->rounds/8*1; break;
      case 9: $id1 = $this->rounds/16*3; break;
      case 10: $id1 = $this->rounds/16*11; break;
      case 11: $id1 = $this->rounds/16*7; break;
      case 12: $id1 = $this->rounds/16*15; break;
      case 13: $id1 = $this->rounds/16*13; break;
      case 14: $id1 = $this->rounds/16*5; break;
      case 15: $id1 = $this->rounds/16*9; break;
      case 16: $id1 = $this->rounds/16*1; break;
      case 17: $id1 = $this->rounds/32*3; break;
      case 18: $id1 = $this->rounds/32*19; break;
      case 19: $id1 = $this->rounds/32*11; break;
      case 20: $id1 = $this->rounds/32*27; break;
      case 21: $id1 = $this->rounds/32*7; break;
      case 22: $id1 = $this->rounds/32*23; break;
      case 23: $id1 = $this->rounds/32*15; break;
      case 24: $id1 = $this->rounds/32*31; break;
      case 25: $id1 = $this->rounds/32*29; break;
      case 26: $id1 = $this->rounds/32*13; break;
      case 27: $id1 = $this->rounds/32*21; break;
      case 28: $id1 = $this->rounds/32*5; break;
      case 29: $id1 = $this->rounds/32*25; break;
      case 30: $id1 = $this->rounds/32*9; break;
      case 31: $id1 = $this->rounds/32*17; break;
      case 32: $id1 = $this->rounds/32*1; break;
      default:
        throw new \Exception('Too many users, not supported jet');
      }

      $id2 = $this->rounds-$id1+1;
      $this->seed_number++;
      $this->round_count++;

      if ($this->round_count % 2 > 0) {
        if ($id1 > $id2) {
          $num1 = $id1;
          $num2 = $id2;
        } else {
          $num1 = $id2;
          $num2 = $id1;
        }
      } else {
        if ($id1 < $id2) {
          $num1 = $id1;
          $num2 = $id2;
        } else {
          $num1 = $id2;
          $num2 = $id1;
        }
      }

      array_push($round['matches'], array(
        array( 'seed' => $num1, 'name' => null, 'result' => null ),
        array( 'seed' => $num2, 'name' => null, 'result' => null )
      ));

    } else {
      array_push($round['matches'], array(
        array( 'seed' => null, 'name' => null, 'result' => null ),
        array( 'seed' => null, 'name' => null, 'result' => null )
      ));
    }

    return $round;
  }

  private function merge($round)
  {
    array_push($this->bracket, $round);
    $this->round_number++;
  }

  private function addBlank()
  {
    return array('blank' => true);
  }
}
