<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CurrencyController extends Controller
{
  /**
   * @Template()
   * @Route("/currency", name="admin_currency")
   */
  public function indexAction()
  {
  }
}
