<?php

namespace Club\AccountBundle\Listener;

class NewTransactionListener
{
  protected $em;
  protected $security_context;

  public function __construct($em, $security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function onShopOrder(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $user = $this->security_context->getToken()->getUser();
    $order = $event->getOrder();

    $vat_account = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('account_default_vat',$user->getLocation());

    foreach ($order->getProducts() as $product) {

      switch ($product->getType()) {
      case 'product':
        $account = $this->em->getRepository('ClubShopBundle:Product')->getAccount($product->getProduct(), $user->getLocation());
        break;
      case 'coupon':
        $account = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('account_default_discount',$user->getLocation());
        break;
      }

      $ledger = new \Club\AccountBundle\Entity\Ledger();
      $ledger->setValue($product->getPrice());
      $ledger->setNote($product->getQuantity().'x '.$product->getProductName());
      $ledger->setAccount($account);
      $ledger->setUser($order->getUser());

      $this->em->persist($ledger);

      if ($product->getVat() > 0) {
        $ledger = new \Club\AccountBundle\Entity\Ledger();
        $ledger->setValue($product->getPrice()*$product->getVat()/100);
        $ledger->setNote('VAT for order '.$order->getOrderNumber());
        $ledger->setAccount($vat_account);
        $ledger->setUser($order->getUser());

        $this->em->persist($ledger);
      }
    }

    $this->em->flush();
  }
}
