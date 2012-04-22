<?php
namespace Club\ShopBundle\Helper;

class PaymentMethod
{
  protected $event_dispatcher;

  public function __construct($event_dispatcher)
  {
    $this->event_dispatcher = $event_dispatcher;
  }

  public function getAll(array $credentials = array())
  {
    $event = new \Club\ShopBundle\Event\FilterPaymentMethodEvent();
    $event->setCredentials($credentials);

    $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onPaymentMethodGet, $event);

    return $event->getMethods($credentials);
  }

  public function getAllArray(array $credentials = array())
  {
    $res = array();
    foreach ($this->getAll($credentials) as $p) {
      $res[$p->getPriority()] = $p;
    }
    ksort($res);

    $r = array();
    foreach ($res as $method) {
      $r[$method->getId()] = $method->getPaymentMethodName();
    }
    return $r;
  }
}
