<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminOrderController extends Controller
{
  /**
   * @Route("/shop/order", name="admin_shop_order")
   * @Template()
   */
  public function indexAction()
  {
  }
}
