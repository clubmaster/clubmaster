<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BookingController extends Controller
{
   /**
    * @Template()
    * @Route("/booking/book/guest/{interval_id}/{date}")
    */
   public function guestAction($interval_id,$date)
   {
     $em = $this->getDoctrine()->getEntityManager();

     $date = new \DateTime($date);
     $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

     $this->get('club_booking.booking')->bindGuest($interval, $date, $this->get('security.context')->getToken()->getUser());

     if ($this->get('club_booking.booking')->isValid()) {
       $this->get('club_booking.booking')->save();
       $this->get('session')->setFlash('notice', 'Your booking has been created');
     } else {
       $this->get('session')->setFlash('error', $this->get('club_booking.booking')->getError());
     }

     return $this->redirect($this->generateUrl('club_booking_booking_index', array('date' => $date->format('Y-m-d'))));
   }

   /**
    * @Template()
    * @Route("/booking/book/user/{interval_id}/{date}")
    * @Method("POST")
    */
   public function userAction($interval_id,$date)
   {
     $user = new \Club\UserBundle\Entity\User();
     $form = $this->createForm(new \Club\BookingBundle\Form\User, $user);
     $form->bindRequest($this->getRequest());

     if ($form->isValid()) {
       $em = $this->getDoctrine()->getEntityManager();

       $date = new \DateTime($date);
       $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

       $user = $em->getRepository('ClubUserBundle:User')->findOneBy(array(
         'member_number' => $user->getMemberNumber()
       ));

       if (!$user) {
         $this->get('session')->setFlash('error', 'User does not exist');
         return $this->redirect($this->generateUrl('club_booking_booking_book', array(
           'interval_id' => $interval->getId(),
           'date' => $date->format('Y-m-d')
         )));
       }

       $this->get('club_booking.booking')->bindUser($interval, $date, $this->get('security.context')->getToken()->getUser(), $user);

       if ($this->get('club_booking.booking')->isValid()) {
         $this->get('club_booking.booking')->save();
         $this->get('session')->setFlash('notice', 'Your booking has been created');
       } else {
         $this->get('session')->setFlash('error', $this->get('club_booking.booking')->getError());
       }

       return $this->redirect($this->generateUrl('club_booking_booking_index', array('date' => $date->format('Y-m-d'))));
     }
   }

   /**
    * @Template()
    * @Route("/booking/book/cancel/{id}")
    */
   public function cancelAction($id)
   {
     $em = $this->getDoctrine()->getEntityManager();

     $booking = $em->find('ClubBookingBundle:Booking', $id);

     $this->get('club_booking.booking')->bindDelete($booking);
     if ($this->get('club_booking.booking')->isValid()) {
       $this->get('club_booking.booking')->remove();
       $this->get('session')->setFlash('notice', 'Booking has been cancelled');
     } else {
       $this->get('session')->setFlash('error', $this->get('club_booking.booking')->getError());
     }

     return $this->redirect($this->generateUrl('club_booking_booking_index', array('date' => $booking->getDate()->format('Y-m-d'))));
   }

   /**
    * @Template()
    * @Route("/booking/book/{interval_id}/{date}")
    */
   public function bookAction($interval_id,$date)
   {
     $em = $this->getDoctrine()->getEntityManager();

     $user = new \Club\UserBundle\Entity\User();
     $form = $this->createForm(new \Club\BookingBundle\Form\User, $user);

     $date = new \DateTime($date);
     $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

     return array(
       'interval' => $interval,
       'date' => $date,
       'form' => $form->createVieW()
     );
   }

  /**
   * @Template()
   * @Route("/booking/{date}", defaults={"date" = null})
   */
   public function indexAction($date)
   {
     $date = ($date == null) ? new \DateTime() : new \DateTime($date);
     $em = $this->getDoctrine()->getEntityManager();

     $nav = $this->getNav();
     $location = $this->get('security.context')->getToken()->getUser()->getLocation();
     $fields = $em->getRepository('ClubBookingBundle:Field')->getFieldsBooking($location, $date);
     $data = $em->getRepository('ClubBookingBundle:Field')->getDayData($location, $date);
     $period = $this->get('club_booking.interval')->getTimePeriod($data['start_time'], $data['end_time'], new \DateInterval('PT60M'));

     return array(
       'period' => $period,
       'fields' => $fields,
       'date' => $date,
       'nav' => $nav
    );
   }

   protected function getNav()
   {
     $nav = array();
     $d = new \DateTime();
     $i = new \DateInterval('P1D');
     $p = new \DatePeriod($d, $i, 6);
     foreach ($p as $dt) {
       $nav[] = $dt;
     }

     return $nav;
   }
}
