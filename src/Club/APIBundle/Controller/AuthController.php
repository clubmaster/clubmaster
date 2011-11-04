<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
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
    if (!$this->validateKey())
      return new Response('Wrong API key', 403);

    return new Response();
  }
}
