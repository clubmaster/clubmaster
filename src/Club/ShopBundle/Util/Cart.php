<?php

namespace Club\ShopBundle\Util;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage;

class Cart
{
  protected $cart;
  protected $session;
  protected $em;
  protected $user;

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
        $this->cart->setCurrency();
        $this->cart->setCurrencyValue();
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
    $order->setCurrency($this->cart->getCurrency()->getCurrencyName());
    $order->setCurrencyValue($this->cart->getCurrency()->getValue());
    $order->setPrice($this->cart->getPrice());
    $order->setPaymentMethod($this->em->find('\Club\ShopBundle\Entity\PaymentMethod',$this->cart->getPaymentMethod()->getId()));
    $order->setShipping($this->em->find('\Club\ShopBundle\Entity\Shipping',$this->cart->getShipping()->getId()));
    $order->setOrderStatus($this->em->getRepository('\Club\ShopBundle\Entity\OrderStatus')->getDefaultStatus());
    $order->setUser($this->user);

    $this->save();
  }

  protected function save()
  {
    $this->em->persist($this->cart);
    $this->em->flush();
  }
}
