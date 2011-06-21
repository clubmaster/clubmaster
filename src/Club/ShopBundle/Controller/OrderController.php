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
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $this->get('security.context')->getToken()->getUser();

    $orders = $em->getRepository('\Club\ShopBundle\Entity\Order')->findBy(array(
      'user' => $user->getId()
    ));

    return array(
      'orders' => $orders
    );
  }

  /**
   * @Route("/shop/order/edit/{id}", name="shop_order_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('\Club\ShopBundle\Entity\Order',$id);

    return array(
      'order' => $order,
    );
  }

  /**
   * @Route("/shop/order/cancel/{id}", name="shop_order_cancel")
   */
  public function cancelAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('\Club\ShopBundle\Entity\Order',$id);

    $status = $em->find('\Club\ShopBundle\Entity\OrderStatus',5);
    $order->setOrderStatus($status);

    $em->persist($order);
    $em->flush();

    $event = new \Club\ShopBundle\Event\FilterOrderEvent($order);
    $this->get('event_dispatcher')->dispatch(\Club\ShopBundle\Event\Events::onOrderChange, $event);

    return $this->redirect($this->generateUrl('shop_order'));
  }
}
