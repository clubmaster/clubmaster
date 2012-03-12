<?php

namespace Club\ShopBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterPaymentMethodEvent extends Event
{
  protected $methods = array();

  public function setMethod($method)
  {
    $this->methods[] = $method;
  }

  public function getMethods()
  {
    return $this->methods;
  }
}
