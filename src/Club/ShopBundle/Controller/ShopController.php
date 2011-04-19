<?php

namespace Club\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopController extends Controller
{
    /**
     * @extra:Route("/shop/category", name="shop_category")
     * @extra:Template()
     */
    public function categoryAction()
    {
      return array();
    }

    /**
     * @extra:Route("/shop/order", name="shop_order")
     * @extra:Template()
     */
    public function orderAction()
    {
      return array();
    }
}
