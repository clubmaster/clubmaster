<?php

namespace Club\BookingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('ClubBookingBundle:Default:index.html.twig', array('name' => $name));
    }
}
