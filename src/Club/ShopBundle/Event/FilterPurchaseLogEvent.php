<?php

namespace Club\ShopBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterPurchaseLogEvent extends Event
{
  protected $purchase_log;

  public function setPurchaseLog(\Club\ShopBundle\Entity\PurchaseLog $purchase_log)
  {
    $this->purchase_log = $purchase_log;
  }

  public function getPurchaseLog() {
    return $this->purchase_log;
  }
}
