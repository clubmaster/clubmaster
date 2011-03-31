<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClubUserBundle:Default:index.html.twig');
    }
}
