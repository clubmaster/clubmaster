<?php

namespace Club\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


class AuthController extends Controller
{
  /**
   * @Route("/auth")
   * @Secure(roles="ROLE_USER")
   */
  public function authAction()
  {
    return new Response();
  }
}
