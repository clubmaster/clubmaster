<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminPlanCategoryController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $plan_categories = $em->getRepository('ClubBookingBundle:PlanCategory')->findAll();

    return array(
      'plan_categories' => $plan_categories
    );
  }

  /**
   * @Route("/new", defaults={"date" = null, "interval_id" = null})
   * @Route("/new/{date}/{interval_id}", name="club_booking_adminplancategory_new1")
   * @Template()
   */
  public function newAction($date, $interval_id)
  {
    $category = new \Club\BookingBundle\Entity\PlanCategory();
    $category->setUser($this->get('security.context')->getToken()->getUser());

    $plan = new \Club\BookingBundle\Entity\Plan();

    $em = $this->getDoctrine()->getEntityManager();
    if ($date != '') {
      $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

      $start = new \DateTime($date.' 00:00:00');
      $end = new \DateTime($date.' 23:59:59');

      $t_start = new \DateTime(date('Y-m-d '.$interval->getStartTime()->format('H:i:s')));
      $t_end = new \DateTime(date('Y-m-d '.$interval->getStopTime()->format('H:i:s')));
      $plan->setFirstDate($t_start);
      $plan->setEndDate($t_end);
      $plan->addField($interval->getField());

    } else {
      $start = new \DateTime(date('Y-m-d 00:00:00'));
      $end = new \DateTime(date('Y-m-d 23:59:59'));
    }

    $plan->setPlanCategory($category);
    $plan->setPeriodStart($start);
    $plan->setPeriodEnd($end);
    $plan->setDay($start->format('N'));

    $form = $this->getPlanForm($plan);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em->persist($plan);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_adminplancategory_index'));
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
    $plan_category = $em->find('ClubBookingBundle:PlanCategory',$id);
    $form = $this->createForm(new \Club\BookingBundle\Form\PlanCategory(), $plan_category);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($plan_category);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_adminplancategory_index'));
      }
    }

    return array(
      'plan_category' => $plan_category,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $plan_category = $em->find('ClubBookingBundle:PlanCategory',$this->getRequest()->get('id'));

    $em->remove($plan_category);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_booking_adminplancategory_index'));
  }

  private function getPlanForm(\Club\BookingBundle\Entity\Plan $plan)
  {
    $days = $this->get('club_booking.interval')->getDays();

    return $this->createFormBuilder($plan)
      ->add('plan_category', new \Club\BookingBundle\Form\PlanCategory())
      ->add('period_start')
      ->add('period_end')
      ->add('first_date')
      ->add('end_date')
      ->add('fields', 'entity', array(
        'class' => 'Club\BookingBundle\Entity\Field',
        'multiple' => true,
        'property' => 'formString'
      ))
      ->add('day', 'choice', array(
        'choices' => $days
      ))
      ->getForm();
  }
}
