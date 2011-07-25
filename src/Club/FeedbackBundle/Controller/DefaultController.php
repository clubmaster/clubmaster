<?php

namespace Club\FeedbackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('ClubFeedbackBundle:Default:index.html.twig', array('name' => $name));
    }
}
