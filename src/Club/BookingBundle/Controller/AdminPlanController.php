<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Club\BookingBundle\Entity\Plan;
use Club\BookingBundle\Entity\PlanRepeat;
use Club\BookingBundle\Form\PlanType;

/**
 * @Route("/admin/booking/plan")
 */
class AdminPlanController extends Controller
{
    /**
     * @Route("")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plans = $em->getRepository('ClubBookingBundle:Plan')->getActive();

        return array(
            'plans' => $plans
        );
    }

    /**
     * @Route("/new", defaults={"date" = false, "interval_id" = null})
     * @Route("/new/{date}/{interval_id}", name="club_booking_plan_pre")
     * @Template()
     */
    public function newAction(Request $request, $date, $interval_id=null)
    {
        $plan = new Plan();
        $plan->setUser($this->getUser());

        $repeat = new PlanRepeat();
        $repeat->setPlan($plan);
        $plan->addPlanRepeat($repeat);

        $em = $this->getDoctrine()->getManager();

        if ($date) {
            $date = new \DateTime($date);
            $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

            $start = clone $date;
            $start->setTime(
                $interval->getStartTime()->format('H'),
                $interval->getStartTime()->format('i'),
                $interval->getStartTime()->format('s')
            );
            $end = clone $date;
            $end->setTime(
                $interval->getStopTime()->format('H'),
                $interval->getStopTime()->format('i'),
                $interval->getStopTime()->format('s')
            );

            $plan->setStart($start);
            $plan->setEnd($end);
            $plan->addField($interval->getField());
        }

        $form = $this->createForm(new PlanType, $plan);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($plan);
            $em->flush();

            $this->validateAvailable($plan);
            $em->persist($plan);
            $em->flush();

            $this->get('club_extra.flash')->addNotice();

            return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction(Request $request, Plan $plan)
    {
        if (!count($plan->getPlanRepeats())) {
            $repeat = new PlanRepeat();
            $repeat->setPlan($plan);
            $plan->addPlanRepeat($repeat);
        }

        $form = $this->createForm(new PlanType, $plan);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($plan);
            $em->flush();

            $this->validateAvailable($plan);
            $em->persist($plan);
            $em->flush();

            $this->get('club_extra.flash')->addNotice();

            return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction(Plan $plan)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($plan);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
    }

    /**
     * @Route("/overwrite/{id}")
     */
    public function overwriteAction(Plan $plan)
    {
        if ($plan->getStatus() == Plan::STATUS_PENDING) {

            $em = $this->getDoctrine()->getManager();

            $bookings = $this->get('club_booking.plan')
                ->process($plan)
                ->getBookings()
                ;

            foreach ($bookings as $booking) {
                $this->get('club_booking.booking')
                    ->setBooking($booking)
                    ->remove()
                    ;
            }

            $plan->setStatus(Plan::STATUS_ACTIVE);
            $em->persist($plan);

            $em->flush();

            $this->get('club_extra.flash')->addNotice();
        }

        return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
    }

    private function validateAvailable(Plan $plan)
    {
        if (!$this->get('club_booking.plan')->isAvailable($plan)) {
            $plan->setStatus(Plan::STATUS_PENDING);

            $this->get('club_extra.flash')->addError($this->get('translator')->trans(
                'Plan is temporary inactive, you are about to overwrite some bookings, please take action, move the plan or delete the bookings'
            ));

        } else {
            $plan->setStatus(Plan::STATUS_ACTIVE);
        }
    }
}
