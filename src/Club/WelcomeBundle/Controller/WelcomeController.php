<?php

namespace Club\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class WelcomeController extends Controller
{

  public function indexAction()
  {
    return $this->render('ClubWelcomeBundle:Welcome:index.html.twig');
  }
}
