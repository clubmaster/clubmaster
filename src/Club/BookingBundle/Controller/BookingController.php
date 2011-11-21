<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BookingController extends Controller
{
  /**
   * @Template()
   * @Route("/booking")
   */
   public function indexAction()
   {
     $em = $this->getDoctrine()->getEntityManager();

     $date = new \DateTime();
     $location = $em->find('ClubUserBundle:Location', 2);

     $fields = $em->getRepository('ClubBookingBundle:Field')->getFieldsOverview($location, $date);

     $data = $em->getRepository('ClubBookingBundle:Field')->getDayData($location, $date);

     $period = $this->get('club_booking.interval')->getTimePeriod($data['start_time'], $data['end_time'], new \DateInterval('PT60M'));

     return array(
       'period' => $period,
       'fields' => $fields,
       'date' => $date
    );
   }
}
