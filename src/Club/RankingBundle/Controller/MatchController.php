<?php

namespace Club\RankingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/ranking/match")
 */
class MatchController extends Controller
{
  /**
   * @Route("/new/{ranking_id}")
   * @Template()
   * @Secure(roles="ROLE_USER")
   */
  public function newAction($ranking_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $ranking = $em->find('ClubRankingBundle:Ranking', $ranking_id);

    $res = array();
    $res['user0'] = $this->get('security.context')->getToken()->getUser()->getName();
    $res['user0_id'] = $this->get('security.context')->getToken()->getUser()->getId();

    $form = $this->get('club_match.match')->getMatchForm($res, $ranking->getGameSet());

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $this->get('club_match.match')->bindMatch($form->getData(), $ranking);

        if ($this->get('club_match.match')->isValid()) {
          $this->get('club_match.match')->save();
          $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

          return $this->redirect($this->generateUrl('club_ranking_ranking_index'));
        } else {
          $this->get('session')->setFlash('error', $this->get('club_match.match')->getError());
        }
      }
    }

    $param = array('form' => $form->createView());
    if ($ranking) $param['ranking'] = $ranking;

    return $param;
  }
}
