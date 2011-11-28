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
   * @Route("/{date}/{interval_id}/book/{user_id}")
   * @Route("/{date}/{interval_id}/book/guest", defaults={"guest"})
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function bookAction($date, $interval_id, $user_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $date = new \DateTime($date);
    $interval = $em->find('ClubBookingBundle:Interval',$interval_id);

    if ($user_id == 'guest') {
      $this->get('club_booking.booking')->bindGuest($interval, $date, $this->get('security.context')->getToken()->getUser());
    } else {
      $partner = $em->find('ClubUserBundle:User', $user_id);
      $this->get('club_booking.booking')->bindUser($interval, $date, $this->get('security.context')->getToken()->getUser(), $partner);
    }

    if (!$this->get('club_booking.booking')->isValid()) {
      $res = array($this->get('club_booking.booking')->getError());

      $response = new Response($this->get('club_api.encode')->encode($res), 403);
      return $response;
    }

    $booking = $this->get('club_booking.booking')->save();

    $response = new Response($this->get('club_api.encode')->encode($booking->toArray()));
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

    return $response;
  }

}
