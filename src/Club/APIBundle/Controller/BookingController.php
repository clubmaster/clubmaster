<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


class BookingController extends Controller
{
  /**
   * @Route("/{date}/{interval_id}/attend")
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function attendAction($date, $interval_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $date = new \DateTime($date);
    $interval = $em->find('ClubBookingBundle:Interval',$interval_id);
    $user = $this->get('security.context')->getToken()->getUser();

    $booking = new \Club\BookingBundle\Entity\Booking();
    $booking->setDate($date);
    $booking->setInterval($interval);
    $booking->setUser($user);

    $em->persist($booking);
    $em->flush();

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

    $booking = $em->find('ClubBookingBundle:Booking', $id);

    $em->remove($booking);
    $em->flush();

    $response = new Response();
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }

  /**
   * @Route("/{start}")
   * @Method("GET")
   */
  public function indexAction($start)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $res = array();

    $start = ($start == null) ? new \DateTime(date('Y-m-d 00:00:00')) : new \DateTime($start.' 00:00:00');
    $end = ($end == null) ? null : new \DateTime($end.' 23:59:59');

    foreach ($em->getRepository('ClubEventBundle:Event')->getAllBetween($start, $end) as $event) {
      $res[] = $event->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
  }

}
