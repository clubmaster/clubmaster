<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Club\UserBundle\Form\LoginForm;

class AuthController extends Controller
{
  /**
   * @Route("/login",name="login")
   * @Template()
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
      'error' => $error,
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
