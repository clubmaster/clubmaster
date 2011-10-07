<?php

namespace Club\ShopBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AutoRenewalListener
{
  protected $em;
  protected $order;

  public function __construct($em, $order)
  {
    $this->em = $em;
    $this->order = $order;
  }

  public function onAutoRenewalTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $subscriptions = $this->em->getRepository('ClubShopBundle:Subscription')->getExpiredSubscriptions();
    foreach ($subscriptions as $subscription) {

      if ($this->em->getRepository('ClubShopBundle:Subscription')->isAutoRenewal($subscription)) {
        $this->copySubscription($subscription);
      } else {
        $subscription->setActive(0);
        $this->em->persist($subscription);
      }
    }
    $this->em->flush();

    $subscriptions = $this->em->getRepository('ClubShopBundle:Subscription')->getEmptyTicketAutoRenewalSubscriptions();
    foreach ($subscriptions as $subscription) {
      $this->copySubscription($subscription);
    }

    $this->em->flush();
  }

  private function copySubscription($subscription)
  {
    $old_order = $subscription->getOrder();
    $this->order->copyOrder($old_order);
    $this->order->addOrderProduct($subscription->getOrderProduct());
    $this->order->save();

    $subscription->setActive(0);
    $this->em->persist($subscription);
  }
}
