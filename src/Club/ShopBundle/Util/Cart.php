<?php

namespace Club\ShopBundle\Util;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Club\ShopBundle\Events;

class Cart
{
  protected $cart;
  protected $session;
  protected $em;
  protected $user;
  protected $order;

  public function __construct($em,$session,$security)
  {
    $this->session = $session;
    $this->em = $em;
    $this->user = $security->getToken()->getUser();

    $this->cart = $this->session->get('cart');
    if (!$this->cart) {
      $this->cart = $em->getRepository('\Club\ShopBundle\Entity\Cart')->findOneBy(
        array('user' => $this->user->getId())
      );

      if (!$this->cart) {
        $this->cart = new \Club\ShopBundle\Entity\Cart();
        $this->cart->setUser($this->user);
        $location = $this->em->find('\Club\UserBundle\Entity\Location',$this->session->get('location_id'));
        $this->cart->setCurrency($location->getCurrency()->getCode());
        $this->cart->setCurrencyValue($location->getCurrency()->getValue());
        $this->cart->setPrice(0);

        $this->setCustomerAddress($this->user);
        $this->setShippingAddress($this->user);
        $this->setBillingAddress($this->user);
      }
    }
  }

  public function addToCart($product)
  {
    $trigger = 0;
    // check if its already in the cart
    foreach ($this->cart->getCartProducts() as $prod) {
      if ($prod->getProduct()->getId() == $product->getId()) {
        $prod->setQuantity($prod->getQuantity()+1);
        $this->cart->setPrice($this->cart->getPrice()+$prod->getPrice());
        $trigger = 1;
      }
    }

    if (!$trigger) {
      $op = new \Club\ShopBundle\Entity\CartProduct();
      $op->setCart($this->cart);
      $op->setProduct($product);
      $op->setProductName($product->getProductName());
      $op->setPrice($product->getPrice());
      $op->setTax($product->getTax()->getRate());
      $op->setQuantity(1);

      foreach ($product->getProductAttributes() as $attr) {
        $opa = new \Club\ShopBundle\Entity\CartProductAttribute();
        $opa->setCartProduct($op);
        $opa->setValue($attr->getValue());
        $opa->setAttributeName($attr->getAttribute()->getAttributeName());

        $op->addCartProductAttribute($opa);
      }

      $this->cart->addCartProduct($op);
      $this->cart->setPrice($this->cart->getPrice()+$op->getPrice());
    }
    $this->save();
  }

  public function emptyCart()
  {
    $this->em->remove($this->cart);
    $this->em->flush();
  }

  public function setShipping($shipping)
  {
    $this->cart->setShipping($shipping);
    $this->save();
  }

  public function setPayment($payment)
  {
    $this->cart->setPayment($payment);
    $this->save();
  }

  public function setCart($cart)
  {
    $this->cart = $cart;
    $this->save();
  }

  public function getCart()
  {
    return $this->cart;
  }

  public function convertToOrder()
  {
    $order = new \Club\ShopBundle\Entity\Order();
    $order->setCurrency($this->cart->getCurrency());
    $order->setCurrencyValue($this->cart->getCurrencyValue());
    $order->setPrice($this->cart->getPrice());
    $order->setPaymentMethod($this->em->find('\Club\ShopBundle\Entity\PaymentMethod',$this->cart->getPaymentMethod()->getId()));
    $order->setShipping($this->em->find('\Club\ShopBundle\Entity\Shipping',$this->cart->getShipping()->getId()));
    $order->setOrderStatus($this->em->getRepository('\Club\ShopBundle\Entity\OrderStatus')->getDefaultStatus());
    $order->setUser($this->user);

    $this->em->persist($order);

    foreach ($this->cart->getCartProducts() as $product) {
      $op = new \Club\ShopBundle\Entity\OrderProduct();
      $op->setOrder($order);
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

    $this->em->remove($this->cart);
    $this->em->flush();

    $this->setOrder($order);
  }

  public function setOrder($order)
  {
    $this->order = $order;
  }

  public function getOrder()
  {
    return $this->order;
  }

  public function setCustomerAddress(\Club\UserBundle\Entity\User $user)
  {
    $address = new \Club\ShopBundle\Entity\CartAddress();
    $address->setFirstName($user->getProfile()->getFirstName());
    $address->setLastName($user->getProfile()->getLastName());

    $addr = $this->em->getRepository('\Club\UserBundle\Entity\Profile')->getDefaultAddress($user->getProfile());

    $address->setStreet($addr->getStreet());
    $address->setPostalCode($addr->getPostalCode());
    $address->setCity($addr->getCity());
    $address->setCountry($addr->getCountry());

    $this->cart->setCustomerAddress($address);

    $this->save();
  }

  public function setShippingAddress(\Club\UserBundle\Entity\User $user)
  {
    $address = new \Club\ShopBundle\Entity\CartAddress();
    $address->setFirstName($user->getProfile()->getFirstName());
    $address->setLastName($user->getProfile()->getLastName());

    $addr = $this->em->getRepository('\Club\UserBundle\Entity\Profile')->getDefaultAddress($user->getProfile());

    $address->setStreet($addr->getStreet());
    $address->setPostalCode($addr->getPostalCode());
    $address->setCity($addr->getCity());
    $address->setCountry($addr->getCountry());

    $this->cart->setShippingAddress($address);

    $this->save();
  }

  public function setBillingAddress(\Club\UserBundle\Entity\User $user)
  {
    $address = new \Club\ShopBundle\Entity\CartAddress();
    $address->setFirstName($user->getProfile()->getFirstName());
    $address->setLastName($user->getProfile()->getLastName());

    $addr = $this->em->getRepository('\Club\UserBundle\Entity\Profile')->getDefaultAddress($user->getProfile());

    $address->setStreet($addr->getStreet());
    $address->setPostalCode($addr->getPostalCode());
    $address->setCity($addr->getCity());
    $address->setCountry($addr->getCountry());

    $this->cart->setBillingAddress($address);

    $this->save();
  }

  protected function save()
  {
    $this->em->persist($this->cart);
    $this->em->flush();
  }
}
