<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TeamController extends Controller
{
  /**
   * @Route("/team/team")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $schedules = $em->getRepository('ClubTeamBundle:Schedule')->getAllBetween(
      new \DateTime(date('Y-m-d 00:00:00')),
      new \DateTime(date('Y-m-d 23:59:59', strtotime('+7 day')))
    );

    return array(
      'schedules' => $schedules,
      'user' => $this->get('security.context')->getToken()->getUser()
    );
  }

  /**
   * @Route("/team/team/{id}/attend")
   * @Template()
   */
  public function attendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    if (!$schedule->addUser($this->get('security.context')->getToken()->getUser())) {
      $this->get('session')->setFlash('error', 'You do not have permission to use teams.');
    } else {

      $errors = $this->get('validator')->validate($schedule, array('attend'));

      if (!count($errors)) {
        $this->get('session')->setFlash('notice', 'You are now attending the team.');
        $em->persist($schedule);
        $em->flush();

        $event = new \Club\TeamBundle\Event\FilterScheduleEvent($schedule);
        $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamAttend, $event);

      } else {
        $this->get('session')->setFlash('error', $errors[0]->getMessage());
      }
    }

    return $this->redirect($this->generateUrl('club_team_team_index'));
  }

  /**
   * @Route("/team/team/{id}/unattend")
   * @Template()
   */
  public function unattendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);
    $user = $this->get('security.context')->getToken()->getUser();

    $schedule->getUsers()->removeElement($user);
    $em->flush();

    $event = new \Club\TeamBundle\Event\FilterScheduleEvent($schedule);
    $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamUnattend, $event);

    $this->get('session')->setFlash('notice', 'You are no longer on the team.');

    return $this->redirect($this->generateUrl('club_team_team_index'));
  }
}
