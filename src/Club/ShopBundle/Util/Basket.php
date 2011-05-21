<?php

namespace Club\ShopBundle\Util;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage;

class Basket
{
  protected $session;
  protected $em;

  public function __construct($em,$session)
  {
    $this->em = $em;
    $this->session = $session;

    $this->order = unserialize($this->session->get('order'));
    if (!$this->order) {
      $this->order = new \Club\ShopBundle\Entity\Order();
    }
  }

  public function addToBasket($product)
  {
    $trigger = 0;
    // check if its already in the basket
    foreach ($this->order->getOrderProducts() as $prod) {
      if ($prod->getProduct()->getId() == $product->getId()) {
        $prod->setQuantity($prod->getQuantity()+1);
        $this->order->setPrice($this->order->getPrice()+$prod->getPrice());
        $trigger = 1;
      }
    }

    if (!$trigger) {
      $op = new \Club\ShopBundle\Entity\OrderProduct();
      $op->setProduct($product);
      $op->setProductName($product->getProductName());
      $op->setPrice($product->getPrice());
      $op->setTax($product->getTax());
      $op->setQuantity(1);

      foreach ($product->getProductAttributes() as $attr) {
        $opa = new \Club\ShopBundle\Entity\OrderProductAttribute();
        $opa->setOrderProduct($op);
        $opa->setValue($attr->getValue());
        $opa->setAttributeName($attr->getAttribute()->getAttributeName());

        $op->addOrderProductAttribute($opa);
      }

      $this->order->addOrderProduct($op);
      $this->order->setPrice($this->order->getPrice()+$op->getPrice());
    }
    $this->setOrder();
  }

  public function emptyBasket()
  {
    $this->order = new \Club\ShopBundle\Entity\Order();
    $this->setOrder();
  }

  public function setUserId($id)
  {
    $basket = $this->getBasket();
    $basket['user_id'] = $id;

    $this->setBasket($basket);
  }

  protected function setOrder()
  {
    $order = serialize($this->order);
    $this->session->set('order', $order);
  }

  public function getOrder()
  {
    return $this->order;
  }
}
