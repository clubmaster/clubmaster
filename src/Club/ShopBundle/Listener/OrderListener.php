<?php

namespace Club\ShopBundle\Listener;

class OrderListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onStoreOrder(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
  }
}
