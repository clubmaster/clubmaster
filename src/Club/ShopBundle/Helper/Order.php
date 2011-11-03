<?php

namespace Club\ShopBundle\Helper;

class Order
{
  private $order;
  private $em;
  private $event_dispatcher;

  public function __construct($em,$event_dispatcher)
  {
    $this->em = $em;
    $this->event_dispatcher = $event_dispatcher;
  }

  public function copyOrder(\Club\ShopBundle\Entity\Order $order)
  {
    $this->createOrder($order);

    $user = $order->getUser();
    $this->setCustomerAddressByUser($user);
    $this->setShippingAddressByUser($user);
    $this->setBillingAddressByUser($user);
    $this->order->setOrderMemo($order->getOrderMemo());
    $this->order->setNote($order->getNote());
    $this->order->setLocation($order->getLocation());
  }

  public function convertToOrder(\Club\ShopBundle\Entity\Cart $cart)
  {
    $this->createOrder($cart);

    $this->setCustomerAddressByCart($cart->getCustomerAddress());
    $this->setShippingAddressByCart($cart->getShippingAddress());
    $this->setBillingAddressByCart($cart->getBillingAddress());

    foreach ($cart->getProducts() as $product) {
      $this->addCartProduct($product);
    }

    $this->em->remove($cart);

    $this->save();
  }

  public function getOrder()
  {
    return $this->order;
  }

  private function setCustomerAddressByUser($user)
  {
    $address = $this->getAddressByUser($user);
    $this->order->setCustomerAddress($address);
  }

  private function setShippingAddressByUser($user)
  {
    $address = $this->getAddressByUser($user);
    $this->order->setShippingAddress($address);
  }

  private function setBillingAddressByUser($user)
  {
    $address = $this->getAddressByUser($user);
    $this->order->setBillingAddress($address);
  }

  private function setCustomerAddressByCart($address)
  {
    $address = $this->getAddressByCart($address);
    $this->order->setCustomerAddress($address);
  }

  private function setShippingAddressByCart($address)
  {
    $address = $this->getAddressByCart($address);
    $this->order->setShippingAddress($address);
  }

  private function setBillingAddressByCart($address)
  {
    $address = $this->getAddressByCart($address);
    $this->order->setBillingAddress($address);
  }

  private function recalcPrice()
  {
    $price = 0;

    foreach ($this->order->getOrderProducts() as $product) {
      $price += $product->getPrice()*$product->getQuantity();
    }

    $this->order->setPrice($price);
  }

  public function save()
  {
    $this->recalcPrice();
    $this->em->persist($this->order);
    $this->em->flush();

    $this->dispatch();
  }

  private function getAddressByCart(\Club\ShopBundle\Entity\CartAddress $addr)
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

  private function getAddressByUser(\Club\UserBundle\Entity\User $user)
  {
    $addr = $user->getProfile()->getProfileAddress();

    $address = new \Club\ShopBundle\Entity\OrderAddress();
    $address->setFirstName($user->getProfile()->getFirstName());
    $address->setLastName($user->getProfile()->getLastName());
    $address->setStreet($addr->getStreet());
    $address->setPostalCode($addr->getPostalCode());
    $address->setCity($addr->getCity());
    $address->setCountry($addr->getCountry()->getCountry());

    return $address;
  }

  private function createOrder($data)
  {
    $this->order = new \Club\ShopBundle\Entity\Order();
    $this->order->setCurrency($data->getCurrency());
    $this->order->setCurrencyValue($data->getCurrencyValue());
    $this->order->setPrice($data->getPrice());
    $this->order->setPaymentMethod($this->em->find('ClubShopBundle:PaymentMethod',$data->getPaymentMethod()->getId()));
    $this->order->setShipping($this->em->find('ClubShopBundle:Shipping',$data->getShipping()->getId()));
    $this->order->setOrderStatus($this->em->getRepository('ClubShopBundle:OrderStatus')->getDefaultStatus());
    $this->order->setUser($data->getUser());
    $this->order->setLocation($data->getLocation());

    $this->em->persist($this->order);
  }

  public function addCartProduct(\Club\ShopBundle\Entity\CartProduct $product)
  {
    $this->addProduct($product);
  }

  public function addOrderProduct(\Club\ShopBundle\Entity\OrderProduct $product)
  {
    $this->addProduct($product);
  }

  private function addProduct($product)
  {
    $op = new \Club\ShopBundle\Entity\OrderProduct();
    $op->setOrder($this->order);
    $op->setPrice($product->getPrice());
    $op->setProductName($product->getProductName());
    $op->setQuantity($product->getQuantity());
    $op->setType($product->getType());
    if ($product->getProduct())
      $op->setProduct($product->getProduct());

    $this->order->addOrderProduct($op);

    foreach ($product->getProductAttributes() as $attr) {
      $opa = new \Club\ShopBundle\Entity\OrderProductAttribute();
      $opa->setOrderProduct($op);
      $opa->setAttributeName($attr->getAttributeName());
      $opa->setValue($attr->getValue());

      $op->addOrderProductAttribute($opa);
      $this->em->persist($opa);
    }

    $this->em->persist($op);
  }

  private function dispatch()
  {
    $event = new \Club\ShopBundle\Event\FilterOrderEvent($this->order);
    $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onShopOrder, $event);
  }
}
