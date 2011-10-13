<?php

namespace Club\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class EventController extends Controller
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
   * @Route("/{id}/attend")
   */
  public function attendAction($id)
  {
  }

  /**
   * @Route("/{id}/unattend")
   */
  public function unattendAction($id)
  {
  }
}
