<?php

namespace Club\ShopBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterCouponEvent extends Event
{
  protected $coupon;

  public function __construct(\Club\ShopBundle\Entity\Coupon $coupon)
  {
    $this->coupon = $coupon;
  }

  public function getCoupon()
  {
    return $this->coupon;
  }
}
