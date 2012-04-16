<?php

namespace Club\MatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GameController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $games = $em->getRepository('ClubMatchBundle:Game')->getTopLists();

    return array(
      'games' => $games
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $game = new \Club\MatchBundle\Entity\Game();

    $res = $this->process($game);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $game = $em->find('ClubMatchBundle:Game',$id);

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
      $game = $em->find('ClubMatchBundle:Game',$this->getRequest()->get('id'));

      $em->remove($game);
      $em->flush();

      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    } catch (\PDOException $e) {
      $this->get('session')->setFlash('error', $this->get('translator')->trans('You cannot delete game which is already being used.'));
    }

    return $this->redirect($this->generateUrl('club_match_admingame_index'));
  }

  protected function process($game)
  {
    $form = $this->createForm(new \Club\MatchBundle\Form\Game(), $game);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($game);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_match_admingame_index'));
      }
    }

    return $form;
  }
}
