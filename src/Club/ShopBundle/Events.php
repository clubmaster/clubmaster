<?php

namespace Club\ShopBundle;

final class Events
{
  /**
   * The onStoreOrder event is thrown each time an order is created
   * in the system.
   *
   * The event listener receives an Acme\StoreBundle\Event\FilterOrderEvent
   * instance.
   *
   * @var string
   */
  const onStoreOrder = 'onStoreOrder';
}
