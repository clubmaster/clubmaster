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
  public function indexAction(\Club\TournamentBundle\Entity\Tournament $tournament)
  {
    return array();
  }

  /**
   * @Route("/show/{id}")
   * @Template()
   */
  public function showAction(\Club\TournamentBundle\Entity\Tournament $tournament)
  {
    $tournament = $this->get('club_tournament.tournament')
      ->setUsers($tournament->getUsers())
      ->setSeeds($tournament->getSeeds())
      ->shuffleUsers()
      ->getBracket();

    return array(
      'tournament' => $tournament
    );
  }
}
