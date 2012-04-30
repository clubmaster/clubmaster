<?php

namespace Club\MatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

        $this->get('club_match.match')->bindMatch($league, $form->getData());

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

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $match = $em->find('ClubMatchBundle:Match',$id);

    if ($match->getProcessed(1))
      $this->get('club_match.league')->revokePoint($match);

    $em->remove($match);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_match_league_index'));
  }

  /**
   * @Route("/show/{id}")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $match = $em->find('ClubMatchBundle:Match',$id);

    return array(
      'match' => $match
    );
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
