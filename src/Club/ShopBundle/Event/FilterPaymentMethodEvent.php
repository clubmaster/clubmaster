<?php

namespace Club\ShopBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterPaymentMethodEvent extends Event
{
  protected $methods = array();
  protected $credentials = array();

  public function addMethod($method)
  {
    $this->methods[] = $method;
  }

  public function getMethods()
  {
    return $this->methods;
  }

  public function setCredentials($credentials)
  {
    $this->credentials = $credentials;
  }

  public function getCredentials()
  {
    return $this->credentials;
  }

}
