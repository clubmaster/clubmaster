<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Club\UserBundle\Form\LoginForm;

class AuthController extends Controller
{
  /**
   * @extra:Template()
   * @extra:Route("/login",name="login")
   */
  public function loginAction()
  {
    if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
      $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    } else {
      $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
    }

    $form = $this->get('form.factory')->create(new LoginForm());
    return array(
      'form' => $form
    );
  }

  public function registerAction()
  {
    return $this->render('ClubUserBundle:Auth:register.html.twig');
  }

  public function forgotAction()
  {
    return $this->render('ClubUserBundle:Auth:forgot.html.twig');
  }
}
