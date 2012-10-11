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
        $data = <<<EOF
BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
SUMMARY:Curiosity landing
DTSTART:20120806T051439Z
LOCATION:Mars
END:VEVENT
BEGIN:VEVENT
UID:1102c450-e0d7-11e1-9b23-0800200c9a66
DTSTART:20120109T140000Z
RRULE:FREQ=MONTHLY;BYDAY=MO;BYSETPOS=2
END:VEVENT
END:VCALENDAR
EOF;

        $start = new \DateTime('2012-01-01');
        $end = new \DateTime('2012-12-31');

        $calendar = \Sabre\VObject\Reader::read($data);
        $calendar->expand($start, $end);

        /**
        foreach ($calendar->VEVENT as $event) {
            var_dump($event->DTSTART->getDateTime());
        }
        die();
         */

        $em = $this->getDoctrine()->getEntityManager();

        $plans = $em->getRepository('ClubBookingBundle:Plan')->findBy(
            array(),
            array('updated_at' => 'DESC')
        );

        return array(
            'plans' => $plans
        );
    }

    /**
     * @Route("/new", defaults={"date" = null, "interval_id" = null})
     * @Route("/new/{date}/{interval_id}", name="club_booking_plan_pre")
     * @Template()
     */
    public function newAction($date, $interval_id)
    {
        $plan = new \Club\BookingBundle\Entity\Plan();
        $plan->setUser($this->getUser());

        $repeat = new \Club\BookingBundle\Entity\PlanRepeat();
        $repeat->setPlan($plan);
        $plan->addPlanRepeat($repeat);


        $em = $this->getDoctrine()->getEntityManager();
        if ($date != '') {
            $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

            $start = new \DateTime($date.' 00:00:00');
            $end = new \DateTime($date.' 23:59:59');

            $t_start = new \DateTime(date('Y-m-d '.$interval->getStartTime()->format('H:i:s')));
            $t_end = new \DateTime(date('Y-m-d '.$interval->getStopTime()->format('H:i:s')));
            $plan->setStart($t_start);
            $plan->setEnd($t_end);
            $plan->addField($interval->getField());
        }

        $form = $this->createForm(new \Club\BookingBundle\Form\Plan, $plan);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $em->persist($plan);
                $em->flush();

                $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

                return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
            } else {
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
                $em = $this->getDoctrine()->getEntityManager();
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($plan);
                $em->flush();

                $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

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
        $em = $this->getDoctrine()->getEntityManager();
        $plan = $em->find('ClubBookingBundle:Plan',$this->getRequest()->get('id'));

        $em->remove($plan);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
    }
}
