<?php

namespace Club\ShopBundle\Listener;

class CouponUseListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onCouponUse(\Club\ShopBundle\Event\FilterCouponEvent $event)
  {
    $coupon = $event->getCoupon();

    $history = new \Club\ShopBundle\Entity\CouponLog();
    $history->setCoupon($coupon);

    $this->em->persist($history);
    $this->em->flush();
  }
}
