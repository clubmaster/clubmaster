<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminSpecialController extends Controller
{
  /**
   * @Route("/shop/special", name="admin_shop_special")
   * @Template()
   */
  public function indexAction()
  {
  }
}
