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

     $fields = $em->getRepository('ClubBookingBundle:Field')->findBy(array(
       'location' => 2
     ));

     return array();
   }
}
