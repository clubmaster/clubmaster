<?php

namespace Club\RankingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MatchCommentController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $games = $em->getRepository('ClubRankingBundle:Game')->getTopLists();

    return array(
      'games' => $games
    );
  }

  /**
   * @Route("/new/{match_id}")
   * @Template()
   */
  public function newAction($match_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $match = $em->find('ClubRankingBundle:Match', $match_id);

    $comment = new \Club\RankingBundle\Entity\MatchComment();
    $comment->setMatch($match);
    $comment->setUser($this->get('security.context')->getToken()->getUser());

    $form = $this->createForm(new \Club\RankingBundle\Form\MatchComment, $comment);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em->persist($comment);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('club_ranking_match_show', array(
          'id' => $match->getId()
        )));
      }
    }

    return array(
      'form' => $form->createView(),
      'match' => $match
    );
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $game = $em->find('ClubRankingBundle:Game',$id);

    $res = $this->process($game);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'game' => $game,
      'form' => $res->createView()
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

  protected function process($game)
  {
    $form = $this->createForm(new \Club\RankingBundle\Form\Game(), $game);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($game);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_ranking_admingame_index'));
      }
    }

    return $form;
  }
}
