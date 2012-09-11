<?php

namespace Club\ShopBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterOrderEvent extends Event
{
  protected $order;

  public function __construct(\Club\ShopBundle\Entity\Order $order)
  {
    $this->order = $order;
  }

  public function getOrder()
  {
    return $this->order;
  }
}
