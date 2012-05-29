<?php

namespace Club\MatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/match/league/match")
 */
class LeagueMatchController extends Controller
{
  /**
   * @Route("/new/{league_id}")
   * @Template()
   * @Secure(roles="ROLE_USER")
   */
  public function newAction($league_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $league = $em->find('ClubMatchBundle:League', $league_id);

    $res = array();
    $res['user0'] = $this->get('security.context')->getToken()->getUser()->getName();
    $res['user0_id'] = $this->get('security.context')->getToken()->getUser()->getId();

    $form = $this->get('club_match.match')->getMatchForm($res, $league->getGameSet());

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $this->get('club_match.match')->bindMatch($form->getData(), $league);

        if ($this->get('club_match.match')->isValid()) {
          $this->get('club_match.match')->save();
          $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

          return $this->redirect($this->generateUrl('club_match_league_index'));
        } else {
          $this->get('session')->setFlash('error', $this->get('club_match.match')->getError());
        }
      }
    }

    $param = array('form' => $form->createView());
    if ($league) $param['league'] = $league;

    return $param;
  }
}
