<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminPlanController extends Controller
{
  /**
   * @Route("/{plan_category_id}")
   * @Template()
   */
  public function indexAction($plan_category_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $plan_category = $em->find('ClubBookingBundle:PlanCategory', $plan_category_id);
    $plans = $em->getRepository('ClubBookingBundle:Plan')->findAll(array(
      'plan_category' => $plan_category_id
    ));

    return array(
      'plans' => $plans,
      'plan_category' => $plan_category
    );
  }

  /**
   * @Route("/{plan_category_id}/new")
   * @Template()
   */
  public function newAction($plan_category_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $plan_category = $em->find('ClubBookingBundle:PlanCategory', $plan_category_id);
    $plan = new \Club\BookingBundle\Entity\Plan();
    $plan->setPlanCategory($plan_category);
    $plan->setUser($this->get('security.context')->getToken()->getUser());
    $plan->setPeriodStart(new \DateTime());
    $plan->setPeriodEnd(new \DateTime());
    $plan->getPeriodEnd()->setTime(23,59,59);

    $form = $this->getForm($plan);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em->persist($plan);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_adminplan_index', array('plan_category_id' => $plan_category_id)));
      }
    }

    return array(
      'form' => $form->createView(),
      'plan_category' => $plan_category
    );
  }

  /**
   * @Route("/{plan_category_id}/edit/{id}")
   * @Template()
   */
  public function editAction($plan_category_id, $id)
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

        return $this->redirect($this->generateUrl('club_booking_adminplan_index', array('plan_category_id' => $plan_category_id)));
      }
    }

    return array(
      'plan' => $plan,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/{plan_category_id}/delete/{id}")
   */
  public function deleteAction($plan_category_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $plan = $em->find('ClubBookingBundle:Plan',$this->getRequest()->get('id'));

    $em->remove($plan);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_booking_adminplan_index', array('plan_category_id' => $plan_category_id)));
  }

  private function getForm(\Club\BookingBundle\Entity\Plan $plan)
  {
    $days = $this->get('club_booking.interval')->getDays();

    return $this->createFormBuilder($plan)
      ->add('period_start')
      ->add('period_end')
      ->add('first_date')
      ->add('end_date')
      ->add('fields')
      ->add('day', 'choice', array(
        'choices' => $days
      ))
      ->getForm();
  }
}
