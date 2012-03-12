<?php

namespace Club\ShopBundle\Event;

final class Events
{
  const onShopOrder = 'shop.order';
  const onOrderChange = 'order.change';
  const onCouponUse = 'coupon.use';
  const onPaymentMethodGet = 'paymentmethod.get';
}
