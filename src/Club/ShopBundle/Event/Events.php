<?php

namespace Club\ShopBundle\Event;

final class Events
{
  const onShopOrder = 'shop.order';
  const onOrderChange = 'order.change';
  const onOrderPay = 'order.pay';
  const onCouponUse = 'coupon.use';
  const onPaymentMethodGet = 'paymentmethod.get';
  const onPurchaseCreate = 'purchase.create';
}
