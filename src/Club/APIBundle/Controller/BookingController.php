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
   * @Route("/book/{date}/{interval_id}/{user_id}")
   * @Route("/book/{date}/{interval_id}/guest", defaults={"guest"})
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
   * @Route("/cancel/{id}")
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function cancelAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $booking = $em->find('ClubBookingBundle:Booking', $id);

    $this->get('club_booking.booking')->bindDelete($booking);
    if (!$this->get('club_booking.booking')->isValid()) {
      $res = array($this->get('club_booking.booking')->getError());
      $response = new Response($this->get('club_api.encode')->encode($res), 403);
      return $response;
    }
    $this->get('club_booking.booking')->remove();

    $response = new Response();
    return $response;
  }

  /**
   * @Route("/{location_id}", defaults={"date" = null})
   * @Route("/{location_id}/{date}")
   * @Method("GET")
   */
  public function indexAction($location_id, $date)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $location = $em->find('ClubUserBundle:Location', $location_id);

    $date = ($date == null) ? new \DateTime() : new \DateTime($date);
    $start = clone $date;
    $start->setTime(0,0,0);
    $end = clone $date;
    $end->setTime(23,59,59);

    $bookings = $em->getRepository('ClubBookingBundle:Booking')->getAllByLocationDate($location, $date);
    $schedules = $em->getRepository('ClubTeamBundle:Schedule')->getAllBetween($start, $end, null, $location);
    $plans = $em->getRepository('ClubBookingBundle:Plan')->getAllBetween($start, $end, $location);

    $res = array();
    foreach ($bookings as $booking) {
      $res[] = $booking->toArray();
    }
    foreach ($schedules as $schedule) {
      $res[] = $schedule->toArray();
    }
    foreach ($plans as $plan) {
      $res[] = $plan->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }
}
