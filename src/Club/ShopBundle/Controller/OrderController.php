<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    /**
     * @Route("/shop/order", name="shop_order")
     * @Template()
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
