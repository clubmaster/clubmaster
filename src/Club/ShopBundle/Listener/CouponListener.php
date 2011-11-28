<?php

namespace Club\ShopBundle\Listener;

class CouponListener
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

    $log = new \Club\ShopBundle\Entity\CouponLog();
    $log->setUser($this->security_context->getToken()->getUser());
    $log->setCoupon($coupon);

    $this->em->persist($log);
    $this->em->flush();
  }
}
