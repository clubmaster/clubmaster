<?php
namespace Club\ShopBundle\Helper;

class PaymentMethod
{
  protected $event_dispatcher;

  public function __construct($event_dispatcher)
  {
    $this->event_dispatcher = $event_dispatcher;
  }

  public function getAll()
  {
    $event = new \Club\ShopBundle\Event\FilterPaymentMethodEvent();
    $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onPaymentMethodGet, $event);

    return $event->getMethods();
  }

  public function getAllArray()
  {
    $res = array();

    foreach ($this->getAll() as $method) {
      $res[$method->getId()] = $method->getPaymentMethodName();
    }

    return $res;
  }
}
