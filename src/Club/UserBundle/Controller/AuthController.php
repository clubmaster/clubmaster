<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller
{
  public function loginAction()
  {
    return $this->render('ClubUser:Auth:login.html.twig');
  }

  public function logoutAction()
  {
    return $this->render('ClubUser:Auth:logout.html.twig');
  }

  public function registerAction()
  {
    return $this->render('ClubUser:Auth:register.html.twig');
  }

  public function forgotAction()
  {
    return $this->render('ClubUser:Auth:forgot.html.twig');
  }
}
