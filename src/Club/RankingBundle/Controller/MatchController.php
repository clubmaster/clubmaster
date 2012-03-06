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

    $form = $this->createFormBuilder($res)
      ->add('user0', 'entity', array(
        'class' => 'ClubUserBundle:User'
      ))
      ->add('user1', 'entity', array(
        'class' => 'ClubUserBundle:User'
      ));

    for ($i = 0; $game->getGameSet() > $i; $i++) {
      $form = $form->add('user0set'.$i,'text', array(
        'label' => 'Set '.($i+1)
      ));
      $form = $form->add('user1set'.$i,'text', array(
        'label' => 'Set '.($i+1)
      ));
    }

    $form = $form->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $this->buildMatch($game, $form->getData());
        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('club_ranking_game_index'));
      }
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

  private function buildMatch(\Club\RankingBundle\Entity\Game $game, $data)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $match = new \Club\RankingBundle\Entity\Match();
    $match->setGame($game);

    $team = new \Club\RankingBundle\Entity\MatchTeam();
    $team->setMatch($match);
    $team_user = new \Club\RankingBundle\Entity\MatchTeamUser();
    $team_user->setUser($data['user0']);
    $team_user->setMatchTeam($team);
    $team->addMatchTeamUser($team_user);
    $match->addMatchTeam($team);

    $team = new \Club\RankingBundle\Entity\MatchTeam();
    $team->setMatch($match);
    $team_user = new \Club\RankingBundle\Entity\MatchTeamUser();
    $team_user->setUser($data['user1']);
    $team_user->setMatchTeam($team);
    $team->addMatchTeamUser($team_user);
    $match->addMatchTeam($team);

    $display = '';
    for ($i = 0; $i < $game->getGameSet(); $i++) {
      if (strlen($data['user0set'.$i])) {
        $set = new \Club\RankingBundle\Entity\MatchSet();
        $set->setMatch($match);
        $set->setGameSet($i+1);
        $set->setValue($data['user0set'.$i]);
        $match->addMatchSet($set);

        $set = new \Club\RankingBundle\Entity\MatchSet();
        $set->setMatch($match);
        $set->setGameSet($i+1);
        $set->setValue($data['user1set'.$i]);
        $match->addMatchSet($set);

        $display .= $data['user0set'.$i].'/'.$data['user1set'.$i].' ';
      }
    }

    $display = trim($display);
    $match->setDisplayResult($display);

    $em->persist($match);
    $em->flush();

    return $match;
  }
}
