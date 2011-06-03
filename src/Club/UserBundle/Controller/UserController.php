<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
  /**
   * @Template()
   * @Route("/user", name="user")
   */
  public function indexAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();

    return array(
      'user' => $user
    );
  }
}
