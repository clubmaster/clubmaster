<?php

namespace Club\ShopBundle\Util;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage;

class Basket
{
  public function __construct()
  {
    $this->session = new Session(new NativeSessionStorage());
    $this->session->start();
  }

  /**
   * @var product ("id" => "", "name" => "", "price" => "", "qty" => "")
   */
  public function addToBasket($product)
  {
    $basket_items = $this->getBasketItems();
    $basket_items[] = $product;

    $this->session->set('basket_items',$basket_items);

    $this->updateBasket($product);
  }

  public function getBasket()
  {
    $basket = $this->session->get('basket');

    if (!is_array($basket)) {
      $basket = array(
        'price' => 0,
        'tax' => 0,
        'user_id' => 0
      );
    }

    return $basket;
  }

  public function getBasketItems()
  {
    $basket_items = $this->session->get('basket_items');

    if (!is_array($basket_items)) {
      $basket_items = array();
    }

    return $basket_items;
  }

  private function updateBasket($product)
  {
    $basket = $this->getBasket();
    $basket['price'] += $product['price'];

    $this->setBasket($basket);
  }

  private function setBasket($basket)
  {
    $this->session->set('basket',$basket);
  }
}
