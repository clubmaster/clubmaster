<?php

namespace Club\RankingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin/ranking")
 */
class AdminRankingController extends Controller
{
  /**
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $rankings = $em->getRepository('ClubRankingBundle:Ranking')->findAll();

    return array(
      'rankings' => $rankings
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

    $ranking = new \Club\RankingBundle\Entity\Ranking();
    $ranking->setStartDate($start);
    $ranking->setEndDate($end);
    $ranking->setGameSet(3);

    $res = $this->process($ranking);

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
    $em = $this->getDoctrine()->getManager();
    $ranking = $em->find('ClubRankingBundle:Ranking',$id);

    $res = $this->process($ranking);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'ranking' => $ranking,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    try {
      $em = $this->getDoctrine()->getManager();
      $ranking = $em->find('ClubRankingBundle:Ranking',$this->getRequest()->get('id'));

      $em->remove($ranking);
      $em->flush();

      $this->get('club_user.flash')->addNotice();

    } catch (\PDOException $e) {
      $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('You cannot delete ranking which is already being used.'));
    }

    return $this->redirect($this->generateUrl('club_ranking_adminranking_index'));
  }

  /**
   * @Route("/users/add/{id}")
   * @Template()
   */
  public function usersAddAction($id)
  {
      $em = $this->getDoctrine()->getManager();

      $res = array();
      $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());

      $form->bind($this->getRequest());
      if ($form->isValid()) {
          $user = $form->get('user')->getData();

          $ranking = $em->find('ClubRankingBundle:Ranking', $id);

          $ranking->addUser($user);
          $em->persist($ranking);
          $em->flush();

          $team = $em->getRepository('ClubMatchBundle:Team')->getTeamByUser($user);
          $em->getRepository('ClubRankingBundle:RankingEntry')->getTeam($ranking, $team);
          $em->flush();

          $this->get('club_user.flash')->addNotice();

      } else {
          foreach ($form->get('user')->getErrors() as $error) {
              $this->get('session')->getFlashBag()->add('error', $error->getMessage());
          }
      }

      return $this->redirect($this->generateUrl('club_ranking_adminranking_users', array(
          'id' => $id
      )));
  }

  /**
   * @Route("/users/delete/{id}/{user_id}")
   */
  public function usersDeleteAction($id, $user_id)
  {
    $em = $this->getDoctrine()->getManager();

    $ranking = $em->find('ClubRankingBundle:Ranking', $id);
    $user = $em->find('ClubUserBundle:User', $user_id);

    $ranking->getUsers()->removeElement($user);
    $em->persist($ranking);
    $em->flush();

    $this->get('club_user.flash')->addNotice();

    return $this->redirect($this->generateUrl('club_ranking_adminranking_users', array(
      'id' => $id
    )));
  }

  /**
   * @Route("/users/{id}")
   * @Template()
   */
  public function usersAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());
    $ranking = $em->find('ClubRankingBundle:Ranking', $id);

    return array(
      'ranking' => $ranking,
      'form' => $form->createView()
    );
  }

  protected function process($ranking)
  {
    $form = $this->createForm(new \Club\RankingBundle\Form\Ranking(), $ranking);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($ranking);
        $em->flush();

        $this->get('club_user.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_ranking_adminranking_index'));
      }
    }

    return $form;
  }
}
