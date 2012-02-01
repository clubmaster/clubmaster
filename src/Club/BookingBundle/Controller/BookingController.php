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
    * @Route("/booking/book/review/{interval_id}/{date}")
    * @Method("POST")
    */
   public function reviewAction($interval_id, $date)
   {
     if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
       $this->get('session')->setFlash('error', 'You has to be logged in.');
       return $this->redirect($this->generateUrl('club_booking_overview_view', array(
         'date' => $date,
         'interval_id' => $interval_id
       )));
     }

     $em = $this->getDoctrine()->getEntityManager();

     $date = new \DateTime($date);
     $interval = $em->find('ClubBookingBundle:Interval', $interval_id);
     $guest = $this->getRequest()->get('guest') ? 1 : 0;

     if ($guest) {
       $this->get('club_booking.booking')->bindGuest($interval, $date, $this->get('security.context')->getToken()->getUser());
     } else {
       $form = $this->createForm(new \Club\BookingBundle\Form\User);
       $form->bindRequest($this->getRequest());

       if ($form->isValid()) {
         $user = $em->getRepository('ClubUserBundle:User')->getBySearch($form->getData());

         if (!count($user)) {
           $this->get('session')->setFlash('error', 'User does not exist');
           return $this->redirect($this->generateUrl('club_booking_overview_view', array(
             'interval_id' => $interval->getId(),
             'date' => $date->format('Y-m-d')
           )));
         } elseif (count($user) > 1) {
           $this->get('session')->setFlash('error', 'Too many users match this search');
           return $this->redirect($this->generateUrl('club_booking_overview_view', array(
             'interval_id' => $interval->getId(),
             'date' => $date->format('Y-m-d')
           )));
         }
       }

       $user = $user[0];
       $this->get('club_booking.booking')->bindUser($interval, $date, $this->get('security.context')->getToken()->getUser(), $user);
     }

     if (!$this->get('club_booking.booking')->isValid()) {
       $this->get('session')->setFlash('error', $this->get('club_booking.booking')->getError());
       return $this->redirect($this->generateUrl('club_booking_overview_view', array(
         'interval_id' => $interval->getId(),
         'date' => $date->format('Y-m-d')
       )));
     }

     $ret = array(
       'guest' => $guest,
       'booking' => $this->get('club_booking.booking')->getBooking(),
       'interval' => $interval
     );

     if (isset($user))
       $ret['user'] = $user;

     $this->get('club_booking.booking')->serialize();

     return $ret;
   }

   /**
    * @Template()
    * @Route("/booking/book/confirm")
    */
   public function confirmAction()
   {
     $this->get('club_booking.booking')->unserialize();
     $em = $this->getDoctrine()->getEntityManager();

     if ($this->get('club_booking.booking')->isValid()) {
       $this->get('club_booking.booking')->save();
       $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your booking has been created'));
     } else {
       $this->get('session')->setFlash('error', $this->get('club_booking.booking')->getError());
     }

     return $this->redirect($this->generateUrl('club_booking_overview_index', array(
       'date' => $this->get('club_booking.booking')->getBooking()->getFirstDate()->format('Y-m-d')
     )));
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
       $this->get('session')->setFlash('notice', $this->get('translator')->trans('Booking has been cancelled'));
     } else {
       $this->get('session')->setFlash('error', $this->get('club_booking.booking')->getError());
     }

     return $this->redirect($this->generateUrl('club_booking_overview_index', array('date' => $booking->getDate()->format('Y-m-d'))));
   }
}
