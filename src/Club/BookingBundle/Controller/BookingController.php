<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Club\BookingBundle\Entity\Booking;

/**
 * @Route("/booking")
 */
class BookingController extends Controller
{
    /**
     * @Template()
     * @Route("/book/addme/{id}")
     */
    public function addMeAction(Booking $booking)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $booking->addUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($booking);
        $em->flush();

        return $this->redirect($this->generateUrl('club_booking_booking_viewbooking', array(
            'booking_id' => $booking->getId()
        )));
    }

    /**
     * @Template()
     * @Route("/book/addplayer/{id}")
     * @Method("POST")
     */
    public function addplayerAction(Request $request, Booking $booking)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $form = $this->getAddPlayerForm($booking);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $form->get('user')->getData();
        } else {
            foreach ($form->get('user')->getErrors() as $error) {
                $this->get('session')->getFlashBag()->add('error', $error->getMessage());
            }

            return $this->redirect($this->generateUrl('club_booking_booking_viewbooking', array(
                'booking_id' => $booking->getId()
            )));
        }

        $this->get('club_booking.booking')->bindAdditional($booking, $user);

        if (!$this->get('club_booking.booking')->isValid()) {
            $this->get('session')->getFlashBag()->add('error', $this->get('club_booking.booking')->getError());

            return $this->redirect($this->generateUrl('club_booking_overview_view', array(
                'id' => $interval->getId(),
                'date' => $date->format('Y-m-d')
            )));
        }

        $booking->addUser($user);

        $em->persist($booking);
        $em->flush();

        return $this->redirect($this->generateUrl('club_booking_booking_viewbooking', array(
            'booking_id' => $booking->getId()
        )));
    }

    /**
     * @Template()
     * @Route("/book/review/{interval_id}/{date}")
     * @Method("POST")
     */
    public function reviewAction($interval_id, \DateTime $date)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

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
                    $this->get('session')->getFlashBag()->add('error', $error->getMessage());
                }

                return $this->redirect($this->generateUrl('club_booking_overview_view', array(
                    'id' => $interval->getId(),
                    'date' => $date->format('Y-m-d')
                )));
            }

            $this->get('club_booking.booking')->bindUser($interval, $date, $this->getUser(), $user);
        }

        if (!$this->get('club_booking.booking')->isValid()) {
            $this->get('session')->getFlashBag()->add('error', $this->get('club_booking.booking')->getError());

            return $this->redirect($this->generateUrl('club_booking_overview_view', array(
                'id' => $interval->getId(),
                'date' => $date->format('Y-m-d')
            )));
        }

        $this->get('club_booking.booking')->serialize();

        if ($this->get('club_booking.booking')->getPrice() == 0) {
            return $this->redirect($this->generateUrl('club_booking_booking_confirm'));
        }

        return array(
            'booking' => $this->get('club_booking.booking')->getBooking(),
            'interval' => $interval,
            'price' => $this->get('club_booking.booking')->getPrice()
        );
    }

    /**
     * @Template()
     * @Route("/book/buy")
     */
    public function buyAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $b = $this->get('club_booking.booking');
        $b->unserialize();
        $b->setStatus(\Club\BookingBundle\Entity\Booking::PENDING);

        $b->save();
        $b->addToCart();

        return $this->redirect($this->generateUrl('shop_checkout'));
    }

    /**
     * @Template()
     * @Route("/book/confirm")
     */
    public function confirmAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $b = $this->get('club_booking.booking');
        $b->unserialize();
        $em = $this->getDoctrine()->getManager();

        $this->get('club_booking.booking')->save();
        $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Your booking has been created'));

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

        if (!$booking_id) {
            throw $this->createNotFoundException('The booking does not exist');
        }

        $em = $this->getDoctrine()->getManager();
        $booking = $em->find('ClubBookingBundle:Booking', $booking_id);

        $form = $this->getAddPlayerForm($booking);

        $isParticipating = false;

        if ($booking->getUser() == $this->getUser()) {
            $isParticipating = true;
        }

        foreach ($booking->getUsers() as $user) {
            if ($user == $this->getUser()) {
                $isParticipating = true;
            }
        }

        return array(
            'booking' => $booking,
            'isParticipating' => $isParticipating,
            'playerForm' => $form->createView()
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

        $em = $this->getDoctrine()->getManager();
        $schedule = $em->find('ClubTeamBundle:Schedule', $team_id);
        $field = $em->find('ClubBookingBundle:Field', $field_id);

        return array(
            'public_teamlist' => $this->container->getParameter('club_team.public_teamlist'),
            'schedule' => $schedule,
            'field' => $field
        );
    }

    /**
     * @Template()
     * @Route("/view/plan/{date}")
     */
    public function viewPlanAction(\DateTime $date)
    {
        $plan_id = $this->getRequest()->request->get('plan_id');
        $field_id = $this->getRequest()->request->get('field_id');

        $time = $this->getRequest()->request->get('time');
        if ($time && preg_match("/^\d{1,2}:\d{2}$/", $time)) {
            list($hour,$min) = preg_split("/:/", $time);
            $date->setTime(
                $hour,
                $min,
                0
            );
        }

        $em = $this->getDoctrine()->getManager();
        $plan = $em->find('ClubBookingBundle:Plan', $plan_id);
        $field = $em->find('ClubBookingBundle:Field', $field_id);

        return array(
            'plan' => $plan,
            'field' => $field,
            'date' => $date
        );
    }

    /**
     * @Template()
     * @Route("/book/unattend/{id}")
     */
    public function unattendAction(Booking $booking)
    {
        $booking->removeUser($this->getUser());

        if (count($booking->getUsers()) >= 1) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Booking has been cancelled'));
        } else {

            return $this->redirect($this->generateUrl('club_booking_booking_cancel', array('id' => $booking->getId())));
        }

        return $this->redirect($this->generateUrl('club_booking_booking_view', array('id' => $booking->getId())));
    }

    /**
     * @Template()
     * @Route("/book/cancel/{id}")
     */
    public function cancelAction(Booking $booking)
    {
        $em = $this->getDoctrine()->getManager();

        $booking = $em->find('ClubBookingBundle:Booking', $id);

        $this->get('club_booking.booking')->bindDelete($booking);
        if ($this->get('club_booking.booking')->isValid()) {
            $this->get('club_booking.booking')->remove();
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Booking has been cancelled'));
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->get('club_booking.booking')->getError());
        }

        return $this->redirect($this->generateUrl('club_booking_overview_index', array('date' => $booking->getFirstDate()->format('Y-m-d'))));
    }

    /**
     * @Template()
     * @Route("/book/exclude/{id}/{datetime}")
     */
    public function excludeAction(\Club\BookingBundle\Entity\Plan $plan, \DateTime $datetime)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_BOOKING_ADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        if (!$plan->getRepeating()) {
            $em->remove($plan);
        } else {
            $exception = new \Club\BookingBundle\Entity\PlanException();
            $exception->setExcludeDate($datetime);
            $exception->setPlan($plan);
            $exception->setUser($this->getUser());

            $em->persist($exception);
        }
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_overview_index', array('date' => $datetime->format('Y-m-d'))));
    }

    public function getAddPlayerForm(Booking $booking)
    {
        return $this->createForm(
            new \Club\UserBundle\Form\UserAjax(),
            array(),
            array(
                'method' => 'POST',
                'action' => $this->generateUrl('club_booking_booking_addplayer', array(
                    'id' => $booking->getId()
                ))
            )
        );
    }
}
