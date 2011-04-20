<?php

namespace Club\ShopBundle\Util;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage;

class Basket
{
  public function __construct()
  {
    $this->session = new Session(new NativeSessionStorage());
  }

  public function addItemToBasket($pro)
  {
  }

  public function getBasket()
  {
    $basket = $this->session->get('basket');
    $basket_items = $this->session->get('basket_items');

    if (!is_array($basket)) {
      $basket = array(
        'amount' => 0,
        'tax' => 0,
        'user_id' => 0
      );
      $basket_items = array(
      );
    }

    return $basket;
  }
}
