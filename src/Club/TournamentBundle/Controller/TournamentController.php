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
    $em = $this->getDoctrine()->getEntityManager();
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
    $em = $this->getDoctrine()->getEntityManager();

    $attending = $em->getRepository('ClubTournamentBundle:Tournament')->isAttending($tournament, $this->get('security.context')->getToken()->getUser());

    $bracket = $this->get('club_tournament.tournament')
      ->setUsers($tournament->getUsers())
      ->setSeeds($tournament->getSeeds())
      ->shuffleUsers()
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
    $em = $this->getDoctrine()->getEntityManager();

    $tournament->addUser($this->get('security.context')->getToken()->getUser());
    $em->persist($tournament);
    $em->flush();

    return $this->redirect($this->generateUrl('club_tournament_tournament_show', array('id' => $tournament->getId())));
  }

  /**
   * @Route("/unattend/{id}")
   * @Template()
   */
  public function unattendAction(\Club\TournamentBundle\Entity\Tournament $tournament)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $tournament->getUsers()->removeElement($this->get('security.context')->getToken()->getUser());
    $em->persist($tournament);
    $em->flush();

    return $this->redirect($this->generateUrl('club_tournament_tournament_show', array('id' => $tournament->getId())));
  }
}
