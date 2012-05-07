<?php

namespace Club\TournamentBundle\Helper;

class Tournament
{
  private $users;
  private $bracket;

  public function setUsers(array $users)
  {
    $this->users = $users;
  }

  public function getBracket()
  {
    $this->bracket = array();

    $r1 = pow(2, floor(log(count($this->users), 2)));
    $r0 = count($this->users) - $r1;

    $round = array(
      'round' => 1,
      'name' => 'First round',
      'matches' => array()
    );

    while (count($this->users) > $r0) {
      array_push($round['matches'], array(
        array(
          'name' => array_shift($this->users),
          'result' => 0
        ),
        array(
          'name' => array_shift($this->users),
          'result' => 0
        )
      ));
    }

    $this->bracket[0] = $round;
    $this->bracket[1] = array(
      'name' => 'Champion',
      'round' => 2,
      'winner' => array(
        'name' => 'Michael Holm'
      )
    );

    return $this->bracket;
  }
}
