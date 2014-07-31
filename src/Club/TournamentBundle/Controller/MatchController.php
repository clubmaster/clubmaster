<?php

namespace Club\TournamentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/tournament/match")
 */
class MatchController extends Controller
{
  /**
   * @Route("/new/{tournament_id}")
   * @Template()
   */
  public function newAction($tournament_id)
  {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
          throw new AccessDeniedException();
      }

    $em = $this->getDoctrine()->getManager();
    $tournament = $em->find('ClubTournamentBundle:Tournament', $tournament_id);

    $res = array();
    $form = $this->get('club_match.match')->getMatchForm($res, $tournament->getGameSet());

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {

        $this->get('club_match.match')->bindMatch($form->getData(), $tournament);

        if ($this->get('club_match.match')->isValid()) {
          $this->get('club_match.match')->save();

          $this->get('club_extra.flash')->addNotice();

          return $this->redirect($this->generateUrl('club_match_league_index'));
        } else {
          $this->get('session')->getFlashBag()->add('error', $this->get('club_match.match')->getError());
        }
      }
    }

    return array(
      'form' => $form->createView(),
      'tournament' => $tournament
    );
  }

  public function getForm($res)
  {
    $res['user0'] = $this->getUser()->getName();
    $res['user0_id'] = $this->getUser()->getId();

    $form = $this->createFormBuilder($res)
      ->add('user0_id', 'hidden')
      ->add('user1_id', 'hidden')
      ->add('user0', 'text')
      ->add('user1', 'text');

    return $form;
  }
}
