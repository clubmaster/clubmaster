<?php

namespace Club\LogBundle\Listener;

class OrderChangeListener
{
  protected $em;
  protected $security_context;

  public function __construct($em,$security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function onOrderChange(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $order = $event->getOrder();
    $log = new \Club\LogBundle\Entity\Log();
    $log->setEvent('onOrderChange');
    $log->setSeverity('informational');
    $log->setLogType('shop');
    $log->setLog('Changed order status on order #'.$order->getId());

    if ($this->security_context->getToken() && $this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
      $log->setUser($this->security_context->getToken()->getUser());

    $this->em->persist($log);
    $this->em->flush();
  }
}
