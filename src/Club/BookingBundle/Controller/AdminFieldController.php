<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminFieldController extends Controller
{
  /**
   * @Route("/booking/field")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $fields = $em->getRepository('ClubBookingBundle:Field')->findAll();

    return array(
      'fields' => $fields
    );
  }

  /**
   * @Route("/booking/field/new")
   * @Template()
   */
  public function newAction()
  {
    $field = new \Club\BookingBundle\Entity\Field();
    $form = $this->createForm(new \Club\BookingBundle\Form\Field(), $field);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($field);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_admininterval_index', array(
          'field_id' => $field->getId()
        )));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/booking/field/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $field = $em->find('ClubBookingBundle:Field',$id);
    $form = $this->createForm(new \Club\BookingBundle\Form\Field(), $field);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($field);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_adminfield_index'));
      }
    }

    return array(
      'field' => $field,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/booking/field/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $field = $em->find('ClubBookingBundle:Field',$this->getRequest()->get('id'));

    $em->remove($field);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_booking_adminfield_index'));
  }
}
