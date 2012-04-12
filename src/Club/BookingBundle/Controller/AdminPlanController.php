<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminPlanController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $plans = $em->getRepository('ClubBookingBundle:Plan')->findAll();

    return array(
      'plans' => $plans
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $plan = new \Club\BookingBundle\Entity\Plan();
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
    $days = $this->get('club_booking.interval')->getDays();

    return $this->createFormBuilder($plan)
      ->add('name')
      ->add('description')
      ->add('period_start')
      ->add('period_end')
      ->add('first_time')
      ->add('end_time')
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
