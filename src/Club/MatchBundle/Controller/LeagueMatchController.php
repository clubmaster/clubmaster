<?php

namespace Club\MatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/match/league/match")
 */
class LeagueMatchController extends Controller
{
  /**
   * @Route("/new/{league_id}")
   * @Template()
   */
  public function newAction($league_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $league = $em->find('ClubMatchBundle:League', $league_id);

    $res = array();
    $form = $this->getForm($res);

    for ($i = 0; $league->getGameSet() > $i; $i++) {
      $form = $form->add('user0set'.$i,'text', array(
        'label' => 'Set '.($i+1),
        'required' => false
      ));
      $form = $form->add('user1set'.$i,'text', array(
        'label' => 'Set '.($i+1),
        'required' => false
      ));
    }

    $form = $form->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $this->get('club_match.match')->bindMatch($form->getData(), $league);

        if ($this->get('club_match.match')->isValid()) {
          $this->get('club_match.match')->save();
          $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        } else {
          $this->get('session')->setFlash('error', $this->get('club_match.match')->getError());
        }
      }

      return $this->redirect($this->generateUrl('club_match_league_index'));
    }

    $param = array('form' => $form->createView());
    if ($league) $param['league'] = $league;

    return $param;
  }

  public function getForm($res)
  {
    $res['user0'] = $this->get('security.context')->getToken()->getUser()->getName();
    $res['user0_id'] = $this->get('security.context')->getToken()->getUser()->getId();

    $form = $this->createFormBuilder($res)
      ->add('user0_id', 'hidden')
      ->add('user1_id', 'hidden')
      ->add('user0', 'text')
      ->add('user1', 'text');

    return $form;
  }
}
