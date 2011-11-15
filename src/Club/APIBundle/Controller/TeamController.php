<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


class TeamController extends Controller
{
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
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
  }

  /**
   * @Route("/{id}/attend")
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function attendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    if (!$schedule->addUser($this->get('security.context')->getToken()->getUser())) {
      $res = array('You do not have the right permission to use teams.');

      $response = new Response($this->get('club_api.encode')->encode($res), 403);
      $response->headers->set('Access-Control-Allow-Origin', '*');

      return $response;

    } else {
      $errors = $this->get('validator')->validate($schedule);

      if (count($errors)) {
        $res = array();
        foreach ($errors as $error) {
          $res[] = $error->getMessage();
        }
        $response = new Response($this->get('club_api.encode')->encode($res), 403);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
      }
    }

    $em->persist($schedule);
    $em->flush();

    $event = new \Club\TeamBundle\Event\FilterScheduleEvent($schedule);
    $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamAttend, $event);

    $response = new Response();
    $response->headers->set('Access-Control-Allow-Origin', '*');
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

    $schedule->getUsers()->removeElement($user);
    $em->flush();

    $event = new \Club\TeamBundle\Event\FilterScheduleEvent($schedule);
    $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamUnattend, $event);

    $response = new Response();
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }
}
