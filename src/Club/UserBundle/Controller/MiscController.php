<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MiscController extends Controller
{
  public function getUsernameAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();
    return new Response($user->getProfile()->getName());
  }
}
