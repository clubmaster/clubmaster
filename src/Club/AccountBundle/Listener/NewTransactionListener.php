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

    $config = $this->em->getRepository('ClubUserBundle:LocationConfig')->getByKey($user->getLocation(),'account_default_income');
    $income_account = $this->em->getRepository('ClubAccountBundle:Account')->findOneBy(array(
      'account_number' => $config->getValue()
    ));

    $config = $this->em->getRepository('ClubUserBundle:LocationConfig')->getByKey($user->getLocation(),'account_default_vat');
    $vat_account = $this->em->getRepository('ClubAccountBundle:Account')->findOneBy(array(
      'account_number' => $config->getValue()
    ));

    foreach ($order->getProducts() as $product) {
      $ledger = new \Club\AccountBundle\Entity\Ledger();
      $ledger->setValue($product->getPrice());
      $ledger->setNote($product->getQuantity().'x '.$product->getProductName());
      $ledger->setAccount($income_account);
      $ledger->setUser($order->getUser());

      $this->em->persist($ledger);

      if ($product->getVat() > 0) {
        $ledger = new \Club\AccountBundle\Entity\Ledger();
        $ledger->setValue($product->getVat());
        $ledger->setNote('VAT for order #'.$order->getId());
        $ledger->setAccount($vat_account);
        $ledger->setUser($order->getUser());

        $this->em->persist($ledger);
      }
    }

    $this->em->flush();
  }
}
