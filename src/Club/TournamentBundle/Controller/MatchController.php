<?php

namespace Club\TournamentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/tournament/match")
 */
class MatchController extends Controller
{
  /**
   * @Route("/new/{tournament_id}")
   * @Template()
   * @Secure(roles="ROLE_USER")
   */
  public function newAction($tournament_id)
  {
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
          $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

          return $this->redirect($this->generateUrl('club_match_league_index'));
        } else {
          $this->get('session')->setFlash('error', $this->get('club_match.match')->getError());
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
