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

    $account = $this->em->find('\Club\AccountBundle\Entity\Account',1);

    $ledger = new \Club\AccountBundle\Entity\Ledger();
    $ledger->setValue($order->getVatPrice());
    $ledger->setNote($order->getId());
    $ledger->setAccount($account);
    $ledger->setUser($order->getUser());

    $this->em->persist($ledger);
    $this->em->flush();
  }
}
