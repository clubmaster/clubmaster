<?php

namespace Club\TournamentBundle\Helper;

class Tournament
{
  private $users;
  private $bracket = array();
  private $round_number = 1;

  public function setUsers(array $users)
  {
    $this->users = $users;
  }

  public function getBracket()
  {
    $round = array(
      'round' => $this->round_number,
      'name' => 'Round '.$this->round_number,
      'matches' => array()
    );
    while (count($this->users) > 1) {
      array_push($round['matches'], array(
        array( 'name' => array_shift($this->users), 'result' => null ),
        array( 'name' => array_shift($this->users), 'result' => null )
      ));
    }
    if (count($this->users) > 0) array_push($round['matches'], array('blank' => true));
    array_push($this->bracket, $round);
    $this->round_number++;

    if (count($this->users) > 0) {
      $round = array(
        'round' => $this->round_number,
        'name' => 'Round '.$this->round_number,
        'matches' => array()
      );
      while (count($this->users) > 0) {
        if (count($this->users) == 1) {
          array_push($round['matches'], array(
            array( 'name' => null, 'result' => null ),
            array( 'name' => array_shift($this->users), 'result' => null )
          ));
        } else {
          array_push($round['matches'], array(
            array( 'name' => array_shift($this->users), 'result' => null ),
            array( 'name' => array_shift($this->users), 'result' => null )
          ));
        }
      }
      array_push($this->bracket, $round);
      $this->round_number++;
    }

    $end_bracket = end($this->bracket);
    for ($r = 1, $n = count($end_bracket['matches']); $n > 1; $r++, $n /= 2) {
      switch ($n) {
      case 16: $name = 'Round of 16'; break;
      case 8:  $name = 'Quarter-finals'; break;
      case 4:  $name = 'Semi-finals'; break;
      case 2:  $name = 'Final'; break;
      default: $name = "Round ".$this->round_number; break;
      }

      $matches = array();
      for ($i = 0; $i < $n/2; $i++) {
        $matches[] = array(
          array( 'name' => null, 'result' => null ),
          array( 'name' => null, 'result' => null )
        );
      }

      $round = array(
        'round' => $this->round_number,
        'name' => $name,
        'matches' => $matches
      );

      array_push($this->bracket, $round);
      $this->round_number++;
    }

    array_push($this->bracket, array(
      'name' => 'Champion',
      'round' => count($this->bracket)+1,
      'winner' => array( 'name' => null )
    ));

    return $this->bracket;
  }
}
