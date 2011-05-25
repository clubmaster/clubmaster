<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminTransactionController extends Controller
{
  /**
   * @Route("/shop/transaction", name="admin_shop_transaction")
   * @Template()
   */
  public function indexAction()
  {
  }
}
