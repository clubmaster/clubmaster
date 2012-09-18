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
    $em = $this->getDoctrine()->getEntityManager();
    $plan = new \Club\BookingBundle\Entity\Plan();

    if ($date != '') {
      $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

      $start = new \DateTime($date.' 00:00:00');
      $end = new \DateTime($date.' 23:59:59');

      $t_start = new \DateTime(date('Y-m-d '.$interval->getStartTime()->format('H:i:s')));
      $t_end = new \DateTime(date('Y-m-d '.$interval->getStopTime()->format('H:i:s')));
      $plan->setFirstTime($t_start);
      $plan->setEndTime($t_end);
      $plan->addField($interval->getField());

    } else {
      $start = new \DateTime(date('Y-m-d 00:00:00'));
      $end = new \DateTime(date('Y-m-d 23:59:59'));
    }

    $plan->setUser($this->get('security.context')->getToken()->getUser());
    $plan->setPeriodStart($start);
    $plan->setPeriodEnd($end);
    $plan->setDay($start->format('N'));

    $form = $this->getForm($plan);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em->persist($plan);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

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
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $plan = $em->find('ClubBookingBundle:Plan',$id);
    $form = $this->getForm($plan);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
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

  private function getForm(\Club\BookingBundle\Entity\Plan $plan)
  {
    return $this->createFormBuilder($plan)
        ->add('name', 'text', array(
            'help' => 'Info: When is the first date the plan will be valid from?'
        ))
        ->add('description', 'textarea', array(
            'help' => 'Info: When is the last day the plan will be valid?'
        ))
        ->add('period_start', 'datetime', array(
            'help' => 'Info: When is the first date the plan will be valid from?'
        ))
        ->add('period_end', 'datetime', array(
            'help' => 'Info: When is the last day the plan will be valid?'
        ))
        ->add('day', 'choice', array(
            'choices' => $this->get('club_booking.interval')->getDays(),
            'help' => 'Info: What day on the week should the plan be booked?'
        ))
        ->add('first_time', 'time', array(
            'help' => 'Info: What time on the day will the plan be valid from?'
        ))
        ->add('end_time', 'time', array(
            'help' => 'Info: What time on the day will the plan end?'
        ))
      ->add('fields', 'entity', array(
        'class' => 'Club\BookingBundle\Entity\Field',
        'multiple' => true,
        'property' => 'formString',
        'help' => 'Info: What fields should be booked for the plan?'
      ))
      ->getForm();
  }
}
