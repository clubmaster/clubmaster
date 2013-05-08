<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/users")
 */
class UserController extends Controller
{
  /**
   * @Route("", defaults={"query" = null})
   * @Route("/search")
   * @Route("/search/{query}")
   * @Method("GET")
   */
  public function indexAction($query=null)
  {
      $request = $this->getRequest();
      $query = ($request->get('query')) ? $request->get('query') : $query;
      $em = $this->getDoctrine()->getManager();

      $limit = $request->get('maxRows');
      switch ($request->get('view')) {
      case 'all':
          $active = false;
          break;
      default:
          $active = true;
      }

      if ($query == null) {
          $users = $em->getRepository('ClubUserBundle:User')->getBySearch(null,'u.member_number', $active, $limit);
      } else {
          $users = $em->getRepository('ClubUserBundle:User')->getBySearch(array(
              'query' => $query
          ), 'u.member_number', $active, $limit);
      }

      $res = array();
      foreach ($users as $user) {
          $res[] = $user->toArray('simple');
      }

      return new Response($this->get('club_api.encode')->encode($res));
  }

  /**
   * @Route("/events", defaults={"start" = null, "end" = null})
   * @Route("/events/{start}", defaults={"end" = null})
   * @Route("/events/{start}/{end}")
   * @Method("GET")
   */
  public function eventsAction($start, $end)
  {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
          throw new AccessDeniedException();
      }

    $em = $this->getDoctrine()->getManager();

    $start = ($start == null) ? new \DateTime(date('Y-m-d 00:00:00')) : new \DateTime($start.' 00:00:00');
    $end = ($end == null) ? new \DateTime(date('Y-m-d 23:59:59', strtotime('+7 day'))) : new \DateTime($end.' 23:59:59');

    $events = $em->getRepository('ClubEventBundle:Event')->getAllBetween($start, $end, $this->getUser());
    $res = array();
    foreach ($events as $event) {
      $res[] = $event->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }

  /**
   * @Route("/teams", defaults={"start" = null, "end" = null})
   * @Route("/teams/{start}", defaults={"end" = null})
   * @Route("/teams/{start}/{end}")
   * @Method("GET")
   */
  public function teamsAction($start, $end)
  {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
          throw new AccessDeniedException();
      }

    $em = $this->getDoctrine()->getManager();

    $start = ($start == null) ? new \DateTime(date('Y-m-d 00:00:00')) : new \DateTime($start.' 00:00:00');
    $end = ($end == null) ? new \DateTime(date('Y-m-d 23:59:59', strtotime('+7 day'))) : new \DateTime($end.' 23:59:59');

    $res = array();
    foreach ($this->getUser()->getSchedules() as $schedule) {
      if ($schedule->getSchedule()->getFirstDate()->getTimestamp() >= $start->getTimestamp() && $schedule->getSchedule()->getFirstDate()->getTimestamp() <= $end->getTimestamp())
        $res[] = $schedule->getSchedule()->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }

  /**
   * @Route("/{id}")
   * @Method("GET")
   */
  public function getAction($id)
  {
    return;
    if (!$this->validateKey())

      return new Response($this->get('club_api.encode')->encode('Wrong API key'), 403);

    $em = $this->getDoctrine()->getManager();
    $user = $em->find('ClubUserBundle:User', $id);

    $response = new Response($this->get('club_api.encode')->encode($user->toArray()));

    return $response;
  }
}
