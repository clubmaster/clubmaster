<?php

namespace Club\Account\EconomicBundle\Listener;

class EconomicLog
{
  protected $container;

  public function __construct($container)
  {
    $this->container = $container;
  }

  public function onPurchaseCreate(\Club\ShopBundle\Event\FilterPurchaseLogEvent $event)
  {
    $purchase = $event->getPurchaseLog();
    return;

    $economic = $this->container->get('club_account_economic.economic');
    $economic->addCashBookEntry($purchase);
  }
}
