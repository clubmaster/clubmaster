<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/user/setting")
 */
class UserSettingController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    // USER SETTINGS
    // receive email on booking
    // disable sharing of booking activities
    // language
    // timeformat
    // timezone

    $boolean = array(
      0 => 'No',
      1 => 'Yes'
    );

    $form  = $this->createFormBuilder()
      ->add('receive_email_on_booking', 'choice', array(
        'choices' => $boolean
      ))
      ->add('public_booking_activity', 'choice', array(
        'choices' => $boolean
      ))
      ->getForm();

    $em = $this->getDoctrine()->getEntityManager();

    return array(
      'form' => $form->createView()
    );
  }
}
