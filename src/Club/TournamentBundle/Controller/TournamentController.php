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
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $tournaments = $em->getRepository('ClubTournamentBundle:Tournament')->findAll();

    return array(
      'tournaments' => $tournaments
    );
  }

  /**
   * @Route("/show/{id}")
   * @Template()
   */
  public function showAction(\Club\TournamentBundle\Entity\Tournament $tournament)
  {
    $attending = false;
    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
      $em = $this->getDoctrine()->getManager();
      $attending = $em->getRepository('ClubTournamentBundle:Tournament')->isAttending($tournament, $this->getUser());
    }

    $bracket = $this->get('club_tournament.tournament')
      ->setTournament($tournament)
      ->getBracket();

    return array(
      'tournament' => $tournament,
      'bracket' => $bracket,
      'attending' => $attending
    );
  }

  /**
   * @Route("/attend/{id}")
   * @Template()
   */
  public function attendAction(\Club\TournamentBundle\Entity\Tournament $tournament)
  {
    try {
      $this->get('club_tournament.tournament')
        ->bindUser($tournament, $this->getUser())
        ->validate()
        ->save();
    } catch (\Exception $e) {
      $this->get('session')->setFlash('error', $e->getMessage());
    }

    return $this->redirect($this->generateUrl('club_tournament_tournament_show', array('id' => $tournament->getId())));
  }

  /**
   * @Route("/unattend/{id}")
   * @Template()
   */
  public function unattendAction(\Club\TournamentBundle\Entity\Tournament $tournament)
  {
    try {
      $this->get('club_tournament.tournament')
        ->removeUser($tournament, $this->getUser());
    } catch (\Exception $e) {
      $this->get('session')->setFlash('error', $e->getMessage());
    }

    return $this->redirect($this->generateUrl('club_tournament_tournament_show', array('id' => $tournament->getId())));
  }
}
