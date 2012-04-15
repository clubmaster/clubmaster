<?php

namespace Club\RankingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MatchController extends Controller
{
  /**
   * @Route("/new/{game_id}")
   * @Template()
   */
  public function newAction($game_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $game = $em->find('ClubRankingBundle:Game', $game_id);

    $res = array();
    $form = $this->getForm($res);

    for ($i = 0; $game->getGameSet() > $i; $i++) {
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

        $this->get('club_ranking.match')->bindMatch($game, $form->getData());

        if ($this->get('club_ranking.match')->isValid()) {
          $this->get('club_ranking.match')->save();
          $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        } else {
          $this->get('session')->setFlash('error', $this->get('club_ranking.match')->getError());
        }
      }

      return $this->redirect($this->generateUrl('club_ranking_game_index'));
    }

    return array(
      'form' => $form->createView(),
      'game' => $game
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    try {
      $em = $this->getDoctrine()->getEntityManager();
      $game = $em->find('ClubRankingBundle:Game',$this->getRequest()->get('id'));

      $em->remove($game);
      $em->flush();

      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    } catch (\PDOException $e) {
      $this->get('session')->setFlash('error', $this->get('translator')->trans('You cannot delete game which is already being used.'));
    }

    return $this->redirect($this->generateUrl('club_ranking_admingame_index'));
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
