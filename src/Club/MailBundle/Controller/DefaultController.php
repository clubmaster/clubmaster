<?php

namespace Club\MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClubMailBundle:Default:index.html.twig');
    }
}
