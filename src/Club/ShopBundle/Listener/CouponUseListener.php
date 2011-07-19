<?php

namespace Club\ShopBundle\Listener;

class CouponUseListener
{
  protected $em;
  protected $security_context;

  public function __construct($em, $security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function onCouponUse(\Club\ShopBundle\Event\FilterCouponEvent $event)
  {
    $coupon = $event->getCoupon();

    $history = new \Club\ShopBundle\Entity\CouponLog();
    $history->setCoupon($coupon);
    $history->setUser($this->security_context->getToken()->getUser());

    $this->em->persist($history);
    $this->em->flush();
  }
}
