<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
  /**
   * @Route("/", defaults={"query" = null})
   * @Route("/search/{query}")
   * @Method("GET")
   */
  public function indexAction($query)
  {
    $em = $this->getDoctrine()->getEntityManager();

    if ($query == null) {
      $users = $em->getRepository('ClubUserBundle:User')->findAll();
    } else {
      $users = $em->getRepository('ClubUserBundle:User')->getBySearch(array(
        'query' => $query
      ));
    }

    $res = array();
    foreach ($users as $user) {
      $res[] = $user->toArray('simple');
    }

    $response = new Response($this->get('club_api.encode')->encode($res));
    return $response;
  }

  /**
   * @Route("/teams", defaults={"start" = null, "end" = null})
   * @Route("/teams/{start}", defaults={"end" = null})
   * @Route("/teams/{start}/{end}")
   * @Method("GET")
   * @Secure(roles="ROLE_USER")
   */
  public function teamsAction($start, $end)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $start = ($start == null) ? new \DateTime(date('Y-m-d 00:00:00')) : new \DateTime($start.' 00:00:00');
    $end = ($end == null) ? new \DateTime(date('Y-m-d 23:59:59', strtotime('+7 day'))) : new \DateTime($end.' 23:59:59');

    $res = array();
    foreach ($this->get('security.context')->getToken()->getUser()->getSchedules() as $schedule) {
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

    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User', $id);

    $response = new Response($this->get('club_api.encode')->encode($user->toArray()));
    return $response;
  }
}
