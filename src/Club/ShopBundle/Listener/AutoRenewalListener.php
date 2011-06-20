<?php

namespace Club\ShopBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AutoRenewalListener
{
  protected $em;
  protected $order;
  protected $event_dispatcher;

  public function __construct($em, $order, $event_dispatcher)
  {
    $this->em = $em;
    $this->order = $order;
    $this->event_dispatcher = $event_dispatcher;
  }

  public function onAutoRenewalTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $subscriptions = $this->em->getRepository('ClubShopBundle:Subscription')->getExpiredAutoRenewalSubscriptions();
    foreach ($subscriptions as $subscription) {
      $old_order = $subscription->getOrder();

      $this->order->copyOrder($old_order);

      $subscription->setAutoRenewal(0);
      $subscription->setIsActive(0);
      $this->em->persist($subscription);
      $this->em->flush();

      $order_status = $this->em->getRepository('ClubShopBundle:OrderStatus')->getAcceptedStatus();
      $order = $this->order->getOrder();
      $order->setOrderStatus($order_status);

      $this->em->persist($order);
      $this->em->flush();

      $filter_event = new \Club\ShopBundle\Event\FilterOrderEvent($order);
      $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onOrderChange, $filter_event);
    }
  }
}
