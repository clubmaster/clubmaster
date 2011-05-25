<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminShippingController extends Controller
{
  /**
   * @Route("/shop/shipping", name="admin_shop_shipping")
   * @Template()
   */
  public function indexAction()
  {
  }
}
