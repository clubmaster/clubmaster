<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminFieldController extends Controller
{
   /**
    * @Template()
    * @Route("/field")
    */
   public function indexAction($interval_id,$date)
   {
     return array();
   }
}
