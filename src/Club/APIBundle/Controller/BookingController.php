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
   * @Route("/{id}/cancel")
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function cancelAction($id)
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
   * @Route("/{date}/{location_id}")
   * @Method("GET")
   */
  public function indexAction($date, $location_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $location = $em->find('ClubUserBundle:Location', $location_id);

    $date = new \DateTime($date);
    $bookings = $em->getRepository('ClubBookingBundle:Booking')->getAllByLocationDate($location, $date);

    $res = array(
      'bookings' => array()
    );
    foreach ($bookings as $booking) {
      $res['bookings'][] = $booking->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
  }

}
