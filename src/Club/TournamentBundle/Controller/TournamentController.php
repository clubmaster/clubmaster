<?php

namespace Club\TournamentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/tournament")
 */
class TournamentController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $total = 5;
    $users = array();
    for ($i = 0; $i < $total; $i++) {
      $users[] = 'Player '.($i+1);
    }

    $this->get('club_tournament.tournament')->setUsers($users);
    $tournament = $this->get('club_tournament.tournament')->getBracket();
    print_r($tournament);

    return array(
      'tournament' => $tournament
    );
  }
}
