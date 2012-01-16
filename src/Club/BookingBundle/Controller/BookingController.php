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
    * @Route("/booking/book/confirm/{interval_id}/{date},")
    */
   public function confirmAction($interval_id, $date)
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
     $form = $this->createForm(new \Club\BookingBundle\Form\User);
     $form->bindRequest($this->getRequest());

     if ($form->isValid()) {
       $em = $this->getDoctrine()->getEntityManager();

       $date = new \DateTime($date);
       $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

       $user = $em->getRepository('ClubUserBundle:User')->getBySearch($form->getData());

       if (!count($user)) {
         $this->get('session')->setFlash('error', 'User does not exist');
         return $this->redirect($this->generateUrl('club_booking_booking_book', array(
           'interval_id' => $interval->getId(),
           'date' => $date->format('Y-m-d')
         )));
       } elseif (count($user) > 1) {
         $this->get('session')->setFlash('error', 'Too many users match this search');
         return $this->redirect($this->generateUrl('club_booking_booking_book', array(
           'interval_id' => $interval->getId(),
           'date' => $date->format('Y-m-d')
         )));
       }

       $user = $user[0];
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
    * @Route("/booking/book/{date}/{interval_id}")
    */
   public function bookAction($date, $interval_id)
   {
     $em = $this->getDoctrine()->getEntityManager();

     $form = $this->createForm(new \Club\BookingBundle\Form\User());

     $date = new \DateTime($date);
     $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

     return array(
       'interval' => $interval,
       'date' => $date,
       'form' => $form->createVieW()
     );
   }
}
