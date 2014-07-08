<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    public function newAction($date, $interval_id=null)
    {
        $plan = new \Club\BookingBundle\Entity\Plan();
        $plan->setUser($this->getUser());

        $repeat = new \Club\BookingBundle\Entity\PlanRepeat();
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

        $form = $this->createForm(new \Club\BookingBundle\Form\Plan, $plan);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em->persist($plan);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

                return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction(\Club\BookingBundle\Entity\Plan $plan)
    {
        if (!count($plan->getPlanRepeats())) {
            $repeat = new \Club\BookingBundle\Entity\PlanRepeat();
            $repeat->setPlan($plan);
            $plan->addPlanRepeat($repeat);
        }

        $form = $this->createForm(new \Club\BookingBundle\Form\Plan, $plan);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em = $this->getDoctrine()->getManager();
                $em->persist($plan);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

                return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
            }
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $plan = $em->find('ClubBookingBundle:Plan',$this->getRequest()->get('id'));

        $em->remove($plan);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
    }
}
