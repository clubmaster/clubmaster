<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminIntervalController extends Controller
{
  /**
   * @Route("/booking/interval/{field_id}")
   * @Template()
   */
  public function indexAction($field_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $field = $em->find('ClubBookingBundle:Field', $field_id);
    $intervals = $em->getRepository('ClubBookingBundle:Interval')->findValidByField($field);

    return array(
      'intervals' => $intervals,
      'field' => $field
    );
  }

  /**
   * @Route("/booking/interval/{field_id}/new")
   * @Template()
   */
  public function newAction($field_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $field = $em->find('ClubBookingBundle:Field', $field_id);
    $interval = new \Club\BookingBundle\Entity\Interval();
    $interval->setField($field);
    $res = $this->process($interval);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView(),
      'field' => $field
    );
  }

  /**
   * @Route("/booking/interval/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $interval = $em->find('ClubBookingBundle:Interval',$id);

    $res = $this->process($interval);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'interval' => $interval,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/booking/interval/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $interval = $em->find('ClubBookingBundle:Interval',$this->getRequest()->get('id'));

    $em->remove($interval);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_booking_admininterval_index', array('field_id' => $interval->getField()->getId())));
  }

  protected function process($interval)
  {
    $form = $this->getForm($interval);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($interval);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_admininterval_index', array('field_id' => $interval->getField()->getId())));
      }
    }

    return $form;
  }

  /**
   * @Route("/booking/interval/{field_id}/manage")
   * @Template()
   */
  public function manageAction($field_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $field = $em->find('ClubBookingBundle:Field', $field_id);

    $date = new \DateTime('next monday');
    $int = new \DateInterval('P1D');
    $period = new \DatePeriod($date, $int, 7);

    $data = array(
      'start_date' => new \DateTime()
    );
    foreach ($period as $dt) {
      $data[$dt->format('N')] = array(
        'interval' => 60,
        'start' => new \DateTime('2000-01-01 08:00:00'),
        'stop' => new \DateTime('2000-01-01 22:00:00')
      );
    }
    $form = $this->createForm(new \Club\BookingBundle\Form\ManageDays(), $data);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      $form_data = $form->getData();

      foreach ($form_data as $key=>$data) {
        if (is_numeric($key)) {
          $time = $data['start'];
          $stop = $data['stop'];
          $t_interval = new \DateInterval('PT'.$data['interval'].'M');

          while ($time < $stop) {
            $interval = new \Club\BookingBundle\Entity\Interval();
            $interval->setField($field);
            $interval->setDay($key);
            $interval->setStartTime(clone $time);
            $time->add($t_interval);
            $interval->setStopTime(clone $time);
            $interval->setValidFrom($form_data['start_date']);

            $em->persist($interval);
          }
        }
      }
      $em->flush();

      $this->get('session')->setFlash('notice', 'Field has been created');
      return $this->redirect($this->generateUrl('club_booking_admininterval_index', array('field_id' => $field->getId())));
    }

    return array(
      'field' => $field,
      'form' => $form->createView(),
    );
  }

  protected function getForm($interval)
  {
      return $this->createFormBuilder($interval)
          ->add('day', 'choice', array(
              'choices' => $this->get('club_booking.interval')->getDays()
          ))
          ->add('start_time')
          ->add('stop_time')
          ->add('field')
          ->add('valid_from', 'jquery_datetime', array(
              'date_widget' => 'single_text',
              'time_widget' => 'single_text'
          ))
          ->add('valid_to', 'jquery_datetime', array(
              'date_widget' => 'single_text',
              'time_widget' => 'single_text'
          ))
          ->getForm();
  }
}
