<?php

namespace Club\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


class EventController extends Controller
{
  /**
   * @Route("/")
   * @Method("GET")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $events = $em->getRepository('ClubEventBundle:Event')->getComing();

    $res = array();
    foreach ($events as $event) {
      $res[] = array(
        'id' => $event->getId(),
        'event_name' => $event->getEventName(),
        'description' => $event->getDescription(),
        'price' => $event->getPrice(),
        'max_attends' => $event->getMaxAttends(),
        'attends' => count($event->getAttends()),
        'start_date' => $event->getStartDate(),
        'stop_date' => $event->getStopDate(),
      );
    }

    return new Response($this->get('club_api.encode')->encode($res));
  }

  /**
   * @Route("/{id}/attend")
   * @Method("POST")
   */
  public function attendAction($id)
  {
  }

  /**
   * @Route("/{id}/unattend")
   * @Method("POST")
   */
  public function unattendAction($id)
  {
  }
}
