<?php

namespace Club\ShopBundle\Helper;

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
    $this->order->setVatPrice($cart->getVatPrice());
    $this->order->setPaymentMethod($this->em->find('\Club\ShopBundle\Entity\PaymentMethod',$cart->getPaymentMethod()->getId()));
    $this->order->setShipping($this->em->find('\Club\ShopBundle\Entity\Shipping',$cart->getShipping()->getId()));
    $this->order->setOrderStatus($this->em->getRepository('\Club\ShopBundle\Entity\OrderStatus')->getDefaultStatus());
    $this->order->setUser($cart->getUser());
    $this->setCustomerAddress($cart->getCustomerAddress());
    $this->setShippingAddress($cart->getShippingAddress());
    $this->setBillingAddress($cart->getBillingAddress());

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
  }

  public function getOrder()
  {
    return $this->order;
  }

  protected function setCustomerAddress(\Club\ShopBundle\Entity\CartAddress $address)
  {
    $address = $this->getAddress($address);
    $this->order->setCustomerAddress($address);
  }

  protected function setShippingAddress($address)
  {
    $address = $this->getAddress($address);
    $this->order->setShippingAddress($address);
  }

  protected function setBillingAddress($address)
  {
    $address = $this->getAddress($address);
    $this->order->setBillingAddress($address);
  }

  protected function save()
  {
    $this->em->persist($this->order);
    $this->em->flush();
  }

  protected function getAddress(\Club\ShopBundle\Entity\CartAddress $addr)
  {
    $address = new \Club\ShopBundle\Entity\OrderAddress();
    $address->setFirstName($addr->getFirstName());
    $address->setLastName($addr->getLastName());
    $address->setStreet($addr->getStreet());
    $address->setPostalCode($addr->getPostalCode());
    $address->setCity($addr->getCity());
    $address->setCountry($addr->getCountry());

    return $address;
  }
}
