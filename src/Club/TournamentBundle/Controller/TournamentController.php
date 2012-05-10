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
    $total = 12;
    $seeds = 0;

    // fix seeds
    // add names of rounds
    $users = array();
    for ($i = 0; $i < $total; $i++) {
      $users[] = 'Player '.($i+1);
    }

    $t = $this->get('club_tournament.tournament');
    $t->setUsers($users);
    $t->setSeeds($seeds);
    $t->shuffleUsers();
    $tournament = $t->getBracket();

    return array(
      'tournament' => $tournament
    );
  }
}
