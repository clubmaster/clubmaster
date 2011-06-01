<?php

namespace Club\AccountBundle\Listener;

class NewTransactionListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onShopOrder(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $order = $event->getOrder();

    // do some work
  }
}
