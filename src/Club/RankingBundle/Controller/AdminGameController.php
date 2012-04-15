<?php

namespace Club\RankingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminGameController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $games = $em->getRepository('ClubRankingBundle:Game')->findAll();

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
    $start = new \DateTime(date('Y-m-d 00:00:00'));
    $end = clone $start;
    $i = new \DateInterval('P1Y');
    $end->add($i);

    $game = new \Club\RankingBundle\Entity\Game();
    $game->setStartDate($start);
    $game->setEndDate($end);
    $game->addAdministrator($this->get('security.context')->getToken()->getUser());

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

  /**
   * @Route("/users/add/{id}")
   * @Template()
   */
  public function usersAddAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $res = array();
    $form = $this->getForm($res);

    $form->bindRequest($this->getRequest());
    if ($form->isValid()) {
      $res = $form->getData();
      $user = $em->find('ClubUserBundle:User', $res['user_id']);
      $game = $em->find('ClubRankingBundle:Game', $id);

      $game->addUser($user);
      $em->persist($game);

      $em->flush();
      $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));
    }

    return $this->redirect($this->generateUrl('club_ranking_admingame_users', array(
      'id' => $id
    )));
  }

  /**
   * @Route("/users/delete/{id}/{user_id}")
   */
  public function usersDeleteAction($id, $user_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $game = $em->find('ClubRankingBundle:Game', $id);
    $user = $em->find('ClubUserBundle:User', $user_id);

    $game->getUsers()->removeElement($user);
    $em->persist($game);
    $em->flush();

    $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_ranking_admingame_users', array(
      'id' => $id
    )));
  }

  /**
   * @Route("/users/{id}")
   * @Template()
   */
  public function usersAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $res = array();
    $form = $this->getForm($res);

    $game = $em->find('ClubRankingBundle:Game', $id);

    return array(
      'game' => $game,
      'form' => $form->createView()
    );
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

  protected function getForm($res)
  {
    $form = $this->createFormBuilder($res)
      ->add('user', 'text')
      ->add('user_id', 'hidden')
      ->getForm();

    return $form;
  }
}
