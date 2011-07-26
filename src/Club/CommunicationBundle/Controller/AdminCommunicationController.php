<?php

namespace Club\CommunicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminCommunicationController extends Controller
{

    public function indexAction($name)
    {
        return $this->render('ClubCommunicationBundle:Default:index.html.twig', array('name' => $name));
    }
}
