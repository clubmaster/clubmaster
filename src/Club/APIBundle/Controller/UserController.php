<?php

namespace Club\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class UserController extends Controller
{
  /**
   * @Route("/")
   */
  public function indexAction()
  {
  }

  /**
   * @Route("/{id}")
   */
  public function showAction($id)
  {
  }

  /**
   * @Route("/{id}/subscription")
   */
  public function subscriptionAction($id)
  {
  }

}
