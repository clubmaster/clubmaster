<?php

namespace Club\ShopBundle\Listener;

class ChangeOrderStatusListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onShopOrder(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $order = $event->getOrder();

    $status = new \Club\ShopBundle\Entity\OrderStatusHistory();
    $status->setOrder($order);
    $status->setOrderStatus($order->getOrderStatus());

    $this->em->persist($status);
    $this->em->flush();
  }
}
