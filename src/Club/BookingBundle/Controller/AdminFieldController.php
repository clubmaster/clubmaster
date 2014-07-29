<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class AdminFieldController extends Controller
{
  /**
   * @Route("/booking/field")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $fields = $em->getRepository('ClubBookingBundle:Field')->getAll();

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
    $field->setOpen(new \DateTime());
    $form = $this->createForm(new \Club\BookingBundle\Form\Field(), $field);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();

        $r = $em->getRepository('ClubBookingBundle:Field')->getNextPosition($field->getLocation());
        $field->setPosition($r);

        $em->persist($field);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_booking_admininterval_index', array(
          'id' => $field->getId()
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
    $em = $this->getDoctrine()->getManager();
    $field = $em->find('ClubBookingBundle:Field',$id);
    $form = $this->createForm(new \Club\BookingBundle\Form\Field(), $field);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($field);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

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
    $em = $this->getDoctrine()->getManager();
    $field = $em->find('ClubBookingBundle:Field',$this->getRequest()->get('id'));

    $em->remove($field);
    $em->flush();

    $this->get('club_extra.flash')->addNotice();

    return $this->redirect($this->generateUrl('club_booking_adminfield_index'));
  }

  /**
   * @Route("/booking/field/up/{id}")
   */
  public function upAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $field = $em->find('ClubBookingBundle:Field',$this->getRequest()->get('id'));

    $old = $em->createQueryBuilder()
      ->select('f')
      ->from('ClubBookingBundle:Field', 'f')
      ->where('f.location = :location')
      ->andWhere('f.position < :position')
      ->orderBy('f.position', 'DESC')
      ->setMaxResults(1)
      ->setParameter('location', $field->getLocation()->getId())
      ->setParameter('position', $field->getPosition())
      ->getQuery()
      ->getOneOrNullResult();

    if ($old) {
      $new_pos = $old->getPosition();
      $old_pos = $field->getPosition();

      $field->setPosition($new_pos);
      $old->setPosition($old_pos);

      $em->persist($field);
      $em->persist($old);
      $em->flush();

      $this->get('club_extra.flash')->addNotice();
    }

    return $this->redirect($this->generateUrl('club_booking_adminfield_index'));
  }

  /**
   * @Route("/booking/field/down/{id}")
   */
  public function downAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $field = $em->find('ClubBookingBundle:Field',$this->getRequest()->get('id'));

    $old = $em->createQueryBuilder()
      ->select('f')
      ->from('ClubBookingBundle:Field', 'f')
      ->where('f.location = :location')
      ->andWhere('f.position > :position')
      ->orderBy('f.position', 'ASC')
      ->setMaxResults(1)
      ->setParameter('location', $field->getLocation()->getId())
      ->setParameter('position', $field->getPosition())
      ->getQuery()
      ->getOneOrNullResult();

    if ($old) {
      $new_pos = $old->getPosition();
      $old_pos = $field->getPosition();

      $field->setPosition($new_pos);
      $old->setPosition($old_pos);

      $em->persist($field);
      $em->persist($old);
      $em->flush();

      $this->get('club_extra.flash')->addNotice();
    }

    return $this->redirect($this->generateUrl('club_booking_adminfield_index'));
  }

}
