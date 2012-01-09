<?php

namespace Club\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('ClubWelcomeBundle:Default:index.html.twig', array('name' => $name));
    }
}
