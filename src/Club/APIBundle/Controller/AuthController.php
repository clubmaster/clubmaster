<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
  /**
   * @Route("/auth")
   */
  public function authAction()
  {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
          throw new AccessDeniedException();
      }

    $user = $this->getUser();

    if ($this->validateKey())
      $this->get('club_checkin.checkin')->checkin();

    $response = new Response($this->get('club_api.encode')->encode($user->toArray()));

    return $response;
  }
}
