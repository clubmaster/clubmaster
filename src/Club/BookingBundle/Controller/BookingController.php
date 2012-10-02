<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/booking")
 */
class BookingController extends Controller
{
    /**
     * @Template()
     * @Route("/book/review/{interval_id}/{date}")
     * @Secure(roles="ROLE_USER")
     * @Method("POST")
     */
    public function reviewAction($interval_id, \DateTime $date)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $interval = $em->find('ClubBookingBundle:Interval', $interval_id);
        $guest = $this->getRequest()->get('guest') ? 1 : 0;

        if ($guest) {
            $this->get('club_booking.booking')->bindGuest($interval, $date, $this->getUser());
        } else {
            $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $user = $form->get('user')->getData();
            } else {
                foreach ($form->get('user')->getErrors() as $error) {
                    $this->get('session')->setFlash('error', $error->getMessage());
                }

                return $this->redirect($this->generateUrl('club_booking_overview_view', array(
                    'id' => $interval->getId(),
                    'date' => $date->format('Y-m-d')
                )));
            }

            $this->get('club_booking.booking')->bindUser($interval, $date, $this->getUser(), $user);
        }

        if (!$this->get('club_booking.booking')->isValid()) {
            $this->get('session')->setFlash('error', $this->get('club_booking.booking')->getError());

            return $this->redirect($this->generateUrl('club_booking_overview_view', array(
                'id' => $interval->getId(),
                'date' => $date->format('Y-m-d')
            )));
        }

        $this->get('club_booking.booking')->serialize();

        return array(
            'booking' => $this->get('club_booking.booking')->getBooking(),
            'interval' => $interval,
            'price' => $this->get('club_booking.booking')->getPrice()
        );
    }

    /**
     * @Template()
     * @Route("/book/confirm")
     * @Secure(roles="ROLE_USER")
     */
    public function confirmAction()
    {
        $this->get('club_booking.booking')->unserialize();
        $em = $this->getDoctrine()->getEntityManager();

        $this->get('club_booking.booking')->save();
        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your booking has been created'));

        return $this->redirect($this->generateUrl('club_booking_overview_index', array(
            'date' => $this->get('club_booking.booking')->getBooking()->getFirstDate()->format('Y-m-d')
        )));
    }

    /**
     * @Template()
     * @Route("/view/booking/{booking_id}", defaults={"booking_id" = null})
     */
    public function viewBookingAction($booking_id)
    {
        if ($this->getRequest()->getMethod() == 'POST') {
            $booking_id = $this->getRequest()->request->get('booking_id');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $booking = $em->find('ClubBookingBundle:Booking', $booking_id);

        return array(
            'booking' => $booking
        );
    }

    /**
     * @Template()
     * @Route("/view/team")
     */
    public function viewTeamAction()
    {
        $team_id = $this->getRequest()->request->get('team_id');
        $field_id = $this->getRequest()->request->get('field_id');

        $em = $this->getDoctrine()->getEntityManager();
        $schedule = $em->find('ClubTeamBundle:Schedule', $team_id);
        $field = $em->find('ClubBookingBundle:Field', $field_id);

        return array(
            'schedule' => $schedule,
            'field' => $field
        );
    }

    /**
     * @Template()
     * @Route("/view/plan/{date}")
     */
    public function viewPlanAction($date)
    {
        $plan_id = $this->getRequest()->request->get('plan_id');
        $field_id = $this->getRequest()->request->get('field_id');

        $em = $this->getDoctrine()->getEntityManager();
        $plan = $em->find('ClubBookingBundle:Plan', $plan_id);
        $field = $em->find('ClubBookingBundle:Field', $field_id);
        $date = new \DateTime($date.' 00:00:00');

        return array(
            'plan' => $plan,
            'field' => $field,
            'date' => $date
        );
    }

    /**
     * @Template()
     * @Route("/book/cancel/{id}")
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

        return $this->redirect($this->generateUrl('club_booking_overview_index', array('date' => $booking->getFirstDate()->format('Y-m-d'))));
    }
}
