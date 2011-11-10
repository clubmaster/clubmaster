<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
   * @Route("/team/team/attend/{id}")
   * @Template()
   */
  public function attendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    $schedule->addUser($this->get('security.context')->getToken()->getUser());

    $em->persist($schedule);
    $em->flush();

    return $this->redirect($this->generateUrl('club_team_team_index'));
  }

  /**
   * @Route("/team/team/unattend/{id}")
   * @Template()
   */
  public function unattendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);
    $user = $this->get('security.context')->getToken()->getUser();

    $schedule->getUsers()->removeElement($user);
    $em->flush();

    return $this->redirect($this->generateUrl('club_team_team_index'));
  }
}
