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
    $sub_attrs = $this->em->getRepository('ClubShopBundle:SubscriptionAttribute')->getExpiredAutoSubscriptions('after');
    foreach ($sub_attrs as $sub_attr) {
      $subscription = $sub_attr->getSubscription();

      $this->copySubscription($subscription);
      $this->em->persist($subscription);
    }

    $sub_attrs = $this->em->getRepository('ClubShopBundle:SubscriptionAttribute')->getExpiredAutoSubscriptions('yearly');
    foreach ($sub_attrs as $sub_attr) {
      $subscription = $sub_attr->getSubscription();

      $date_str = $subscription->getStartDate()->format(date('Y').'-m-d H:i:s');
      $d = new \DateTime($date_str);

      if ($d < new \DateTime()) {
        $this->copySubscription($subscription);
        $this->em->persist($subscription);
      }
    }

    $subscriptions = $this->em->getRepository('ClubShopBundle:Subscription')->getEmptyTicketAutoRenewalSubscriptions();
    foreach ($subscriptions as $subscription) {
      $this->copySubscription($subscription);
    }

    $this->em->flush();
  }

  private function copySubscription($subscription)
  {
    $old_order = $subscription->getOrder();

    $attr = $this->em->getRepository('ClubShopBundle:SubscriptionAttribute')->findOneBy(array(
      'subscription' => $subscription->getId(),
      'attribute_name' => 'auto_renewal'
    ));
    $attr->setAttributeName('renewed');

    $this->order->copyOrder($old_order);
    $this->order->addOrderProduct($subscription->getOrderProduct());
    $this->order->save();

    $this->em->persist($attr);
    $this->em->persist($subscription);
  }
}
