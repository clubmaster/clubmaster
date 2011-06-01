<?php

namespace Club\ShopBundle\Util;

class Order
{
  protected $order;
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function convertToOrder(\Club\ShopBundle\Entity\Cart $cart)
  {
    $this->order = new \Club\ShopBundle\Entity\Order();
    $this->order->setCurrency($cart->getCurrency());
    $this->order->setCurrencyValue($cart->getCurrencyValue());
    $this->order->setPrice($cart->getPrice());
    $this->order->setPaymentMethod($this->em->find('\Club\ShopBundle\Entity\PaymentMethod',$cart->getPaymentMethod()->getId()));
    $this->order->setShipping($this->em->find('\Club\ShopBundle\Entity\Shipping',$cart->getShipping()->getId()));
    $this->order->setOrderStatus($this->em->getRepository('\Club\ShopBundle\Entity\OrderStatus')->getDefaultStatus());
    $this->order->setUser($cart->getUser());

    $this->em->persist($this->order);

    foreach ($cart->getCartProducts() as $product) {
      $op = new \Club\ShopBundle\Entity\OrderProduct();
      $op->setOrder($this->order);
      $op->setPrice($product->getPrice());
      $op->setProductName($product->getProductName());
      $op->setTax($product->getTax());
      $op->setQuantity($product->getQuantity());
      $op->setProduct($product->getProduct());

      $this->em->persist($op);

      foreach ($product->getCartProductAttributes() as $attr) {
        $opa = new \Club\ShopBundle\Entity\OrderProductAttribute();
        $opa->setOrderProduct($op);
        $opa->setAttributeName($attr->getAttributeName());
        $opa->setValue($attr->getValue());

        $this->em->persist($opa);
      }
    }

    $this->em->remove($cart);
    $this->em->flush();

    $this->setOrder($this->order);
  }

  public function setOrder($order)
  {
    $this->order = $order;
  }

  public function getOrder()
  {
    return $this->order;
  }

  protected function save()
  {
    $this->em->persist($this->order);
    $this->em->flush();
  }
}
