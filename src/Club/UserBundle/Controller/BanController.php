<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BanController extends Controller
{
  /**
   * @Route("/ban",name="ban")
   * @Template()
   */
  public function banAction()
  {
  }
}
