<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Club\UserBundle\Form\LoginForm;

class AuthController extends Controller
{
  /**
   * @extra:Template()
   * @extra:Route("/login",name="login")
   */
  public function loginAction()
  {
    $form = LoginForm::create($this->get('form.context','login'));
    return array(
      'form' => $form
    );
  }

  /**
   * @extra:Template()
   * @extra:Route("/login_check",name="login_check")
   */
  public function loginCheckAction()
  {
    die('die fucker...');
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
