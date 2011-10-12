<?php

namespace Club\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('ClubDashboardBundle:Default:index.html.twig', array('name' => $name));
    }
}
