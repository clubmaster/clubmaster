<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminCategoryController extends Controller
{
  /**
   * @Route("/shop/category", name="admin_shop_category")
   * @Template()
   */
  public function indexAction()
  {
  }
}
