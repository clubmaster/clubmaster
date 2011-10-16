<?php

namespace Club\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


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
   * @Method("GET")
   * @Secure(roles="ROLE_USER")
   */
  public function attendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $event = $em->find('ClubEventBundle:Event', $id);
    $user = $this->get('security.context')->getToken()->getUser();

    $attend = new \Club\EventBundle\Entity\Attend();
    $attend->setUser($user);
    $attend->setEvent($event);

    $event->addAttends($attend);

    $em->persist($event);
    $em->flush();

    return new Response();
  }

  /**
   * @Route("/{id}/unattend")
   * @Method("GET")
   */
  public function unattendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = $this->get('security.context')->getToken()->getUser();

    $attend = $em->getRepository('ClubEventBundle:Attend')->findOneBy(array(
      'event' => $id,
      'user' => $user->getId()
    ));

    $em->remove($attend);
    $em->flush();

    return new Response();

  }
}
