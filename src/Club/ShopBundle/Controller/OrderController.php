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

    $orders = $em->getRepository('ClubShopBundle:Order')->findBy(array(
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
    $order = $em->find('ClubShopBundle:Order',$id);

    $payments = $this->get('shop_paymentmethod')->getAll(
      array('online_payment' => true)
    );

    $this->validateOwner($order);
    return array(
      'order' => $order,
      'payments' => $payments
    );
  }

  /**
   * @Route("/shop/order/cancel/{id}", name="shop_order_cancel")
   */
  public function cancelAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order',$id);

    $this->validateOwner($order);
    $status = $em->getRepository('ClubShopBundle:OrderStatus')->getCancelledStatus();
    $order->setOrderStatus($status);

    $em->persist($order);
    $em->flush();

    $event = new \Club\ShopBundle\Event\FilterOrderEvent($order);
    $this->get('event_dispatcher')->dispatch(\Club\ShopBundle\Event\Events::onOrderChange, $event);

    return $this->redirect($this->generateUrl('shop_order'));
  }

  private function validateOwner(\Club\ShopBundle\Entity\Order $order)
  {
    $user = $this->get('security.context')->getToken()->getUser();

    // FIXME, does security not allowed exception exists
    if ($order->getUser()->getId() != $user->getId())
      throw new \Exception('You are not allowed to change this order.');
  }
}
