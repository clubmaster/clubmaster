<?php

namespace Club\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    /**
     * @extra:Route("/shop/order", name="shop_order")
     * @extra:Template()
     */
    public function orderAction()
    {
      $em = $this->get('doctrine.orm.entity_manager');

      $orders = $em->getRepository('Club\ShopBundle\Entity\Order')->findAll();
      return array(
        'orders' => $orders
      );
    }
}
