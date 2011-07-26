<?php

namespace Club\CommunicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminCommunicationController extends Controller
{
  /**
   * @Route("/communication")
   * @Template()
   */
  public function indexAction()
  {
    return array();
  }
}
