<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfigController extends Controller
{
  /**
   * @Template()
   * @Route("/config", name="config")
   */
  public function indexAction()
  {
  }
}
