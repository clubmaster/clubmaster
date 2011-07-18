<?php

namespace Club\ShopBundle\Helper;

class Order
{
  protected $order;
  protected $em;
  protected $event_dispatcher;

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

    $this->addProducts($order);

    $this->save();
  }

  public function convertToOrder(\Club\ShopBundle\Entity\Cart $cart)
  {
    $this->createOrder($cart);

    $this->setCustomerAddressByCart($cart->getCustomerAddress());
    $this->setShippingAddressByCart($cart->getShippingAddress());
    $this->setBillingAddressByCart($cart->getBillingAddress());

    $this->addProducts($cart);
    $this->em->remove($cart);

    $this->save();
  }

  public function getOrder()
  {
    return $this->order;
  }

  protected function setCustomerAddressByUser($user)
  {
    $address = $this->getAddressByUser($user);
    $this->order->setCustomerAddress($address);
  }

  protected function setShippingAddressByUser($user)
  {
    $address = $this->getAddressByUser($user);
    $this->order->setShippingAddress($address);
  }

  protected function setBillingAddressByUser($user)
  {
    $address = $this->getAddressByUser($user);
    $this->order->setBillingAddress($address);
  }

  protected function setCustomerAddressByCart($address)
  {
    $address = $this->getAddressByCart($address);
    $this->order->setCustomerAddress($address);
  }

  protected function setShippingAddressByCart($address)
  {
    $address = $this->getAddressByCart($address);
    $this->order->setShippingAddress($address);
  }

  protected function setBillingAddressByCart($address)
  {
    $address = $this->getAddressByCart($address);
    $this->order->setBillingAddress($address);
  }

  protected function save()
  {
    $this->em->persist($this->order);
    $this->em->flush();

    $this->dispatch();
  }

  protected function getAddressByCart(\Club\ShopBundle\Entity\CartAddress $addr)
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

  protected function getAddressByUser(\Club\UserBundle\Entity\User $user)
  {
    $addr = $this->em->getRepository('ClubUserBundle:Profile')->getDefaultAddress($user->getProfile());

    $address = new \Club\ShopBundle\Entity\OrderAddress();
    $address->setFirstName($user->getProfile()->getFirstName());
    $address->setLastName($user->getProfile()->getLastName());
    $address->setStreet($addr->getStreet());
    $address->setPostalCode($addr->getPostalCode());
    $address->setCity($addr->getCity());
    $address->setCountry($addr->getCountry()->getCountry());

    return $address;
  }

  protected function createOrder($data)
  {
    $this->order = new \Club\ShopBundle\Entity\Order();
    $this->order->setCurrency($data->getCurrency());
    $this->order->setCurrencyValue($data->getCurrencyValue());
    $this->order->setPrice($data->getPrice());
    $this->order->setVatPrice($data->getVatPrice());
    $this->order->setPaymentMethod($this->em->find('ClubShopBundle:PaymentMethod',$data->getPaymentMethod()->getId()));
    $this->order->setShipping($this->em->find('ClubShopBundle:Shipping',$data->getShipping()->getId()));
    $this->order->setOrderStatus($this->em->getRepository('ClubShopBundle:OrderStatus')->getDefaultStatus());
    $this->order->setUser($data->getUser());

    $this->em->persist($this->order);
  }

  protected function addProducts($data)
  {
    foreach ($data->getProducts() as $product) {
      $op = new \Club\ShopBundle\Entity\OrderProduct();
      $op->setOrder($this->order);
      $op->setPrice($product->getPrice());
      $op->setProductName($product->getProductName());
      $op->setVat($product->getVat());
      $op->setQuantity($product->getQuantity());
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
  }

  protected function dispatch()
  {
    $event = new \Club\ShopBundle\Event\FilterOrderEvent($this->order);
    $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onShopOrder, $event);
  }
}
