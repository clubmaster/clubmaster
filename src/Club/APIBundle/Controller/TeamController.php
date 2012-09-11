<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/teams")
 */
class TeamController extends Controller
{
  /**
   * @Route("/{id}/attend")
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function attendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    $this->get('club_team.team')->bindAttend($schedule, $this->get('security.context')->getToken()->getUser());
    if (!$this->get('club_team.team')->isValid()) {
      $res = $this->get('club_team.team')->getError();

      return new Response($this->get('club_api.encode')->encodeError($res), 403);
    }
    $this->get('club_team.team')->save();

    $event = new \Club\TeamBundle\Event\FilterScheduleEvent($schedule, $this->get('security.context')->getToken()->getUser());
    $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamAttend, $event);

    $response = new Response();

    return $response;
  }

  /**
   * @Route("/{id}/unattend")
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function unattendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);
    $user = $this->get('security.context')->getToken()->getUser();

    $this->get('club_team.team')->bindUnattend($schedule, $user);
    if (!$this->get('club_team.team')->isValid()) {
      $res = $this->get('club_team.team')->getError();

      return new Response($this->get('club_api.encode')->encodeError($res), 403);
    }
    $this->get('club_team.team')->remove();

    $event = new \Club\TeamBundle\Event\FilterScheduleEvent($schedule, $this->get('security.context')->getToken()->getUser());
    $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamUnattend, $event);

    $response = new Response();

    return $response;
  }

  /**
   * @Route("/", defaults={"start" = null, "end" = null})
   * @Route("/{start}", defaults={"end" = null})
   * @Route("/{start}/{end}")
   * @Method("GET")
   */
  public function indexAction($start, $end)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $res = array();

    $start = ($start == null) ? new \DateTime(date('Y-m-d 00:00:00')) : new \DateTime($start.' 00:00:00');
    $end = ($end == null) ? new \DateTime(date('Y-m-d 23:59:59', strtotime('+7 day'))) : new \DateTime($end.' 23:59:59');

    foreach ($em->getRepository('ClubTeamBundle:Schedule')->getAllBetween($start, $end) as $schedule) {
      $res[] = $schedule->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }
}
