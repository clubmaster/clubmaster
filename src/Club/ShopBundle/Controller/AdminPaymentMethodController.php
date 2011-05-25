<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminPaymentMethodController extends Controller
{
  /**
   * @Route("/shop/payment_method", name="admin_shop_payment_method")
   * @Template()
   */
  public function indexAction()
  {
  }
}
