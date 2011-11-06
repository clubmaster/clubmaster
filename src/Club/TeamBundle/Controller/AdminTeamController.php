<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminTeamController extends Controller
{
  /**
   * @Route("/team/team")
   * @Template()
   */
  public function indexAction()
  {
    $calendar_date = $this->get('session')->get('calendar_date');

    if (!$calendar_date) {
      $calendar_date = new \DateTime(date('Y-m-'.'01'));
      $this->get('session')->set('calendar_date',$calendar_date);
    }

    $em = $this->getDoctrine()->getEntityManager();
    $teams = $em->getRepository('ClubTeamBundle:Team')->getByDate($calendar_date);

    $current = new \DateTime($calendar_date->format('Y-m-d'));
    $prev = new \DateTime($calendar_date->format('Y-m-d'));
    $next = new \DateTime($calendar_date->format('Y-m-d'));
    $prev->modify('-1 month');
    $next->modify('+1 month');

    return array(
      'current' => $current,
      'prev' => $prev,
      'next' => $next,
      'teams' => $teams
    );
  }

  /**
   * @Route("/team/team/prev")
   */
  public function prevAction()
  {
    $calendar_date = $this->get('session')->get('calendar_date');
    $calendar_date->modify('-1 month');

    return $this->redirect($this->generateUrl('admin_team_team'));
  }

  /**
   * @Route("/team/team/next")
   */
  public function nextAction()
  {
    $calendar_date = $this->get('session')->get('calendar_date');
    $calendar_date->modify('+1 month');

    return $this->redirect($this->generateUrl('admin_team_team'));
  }

  /**
   * @Route("/team/team/new/{year}/{month}", defaults={"year" = null, "month" = null})
   * @Template()
   */
  public function newAction($year, $month)
  {
    $time = mktime(0,0,0,$month,1,$year);

    $team = new \Club\TeamBundle\Entity\Team();
    $team->setStartDate(new \DateTime(date('Y-m-d', $time)));
    $team->setStopDate(new \DateTime(date('Y-m-d', $time)));

    $res = $this->process($team);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/team/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$id);

    $res = $this->process($team);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'team' => $team,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/team/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$this->getRequest()->get('id'));

    $em->remove($team);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_team_team'));
  }

  protected function process($team)
  {
    $form = $this->createForm(new \Club\TeamBundle\Form\Team(), $team);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($team);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_team_team'));
      }
    }

    return $form;
  }
}
