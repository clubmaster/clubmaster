<?php

namespace Club\ShopBundle\Helper;

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
        $location = $this->user->getLocation();
        $currency = $em->find('ClubUserBundle:Currency',$this->em->getRepository('ClubUserBundle:LocationConfig')->getValueByKey('default_currency',$location));
        $this->cart->setCurrency($currency);
        $this->cart->setCurrencyValue($currency->getValue());
        $this->cart->setPrice(0);
        $this->cart->setVatPrice(0);
        $this->cart->setLocation($location);

        if ($this->getUserAddress($this->user)) {
          $this->setCustomerAddress($this->user);
        }

        $this->save();
      }
    }
  }

  public function checkLocation($product)
  {
    $trigger = 0;
    foreach ($product->getCategories() as $category) {
      if ($this->cart->getLocation()->getId() == $category->getLocation()->getId())
        $trigger = 1;
    }

    if (!$trigger)
      throw new \Exception('This product does not exists in this shop');
  }

  public function addToCart($product)
  {
    $this->checkLocation($product);

    $trigger = 0;
    // check if its already in the cart
    foreach ($this->cart->getCartProducts() as $prod) {
      if ($prod->getProduct()->getId() == $product->getId()) {
        $prod->setQuantity($prod->getQuantity()+1);
        $this->cart->setPrice($this->cart->getPrice()+$prod->getPrice());
        $this->cart->setVatPrice($this->cart->getVatPrice()+$prod->getVatPrice());
        $trigger = 1;
      }
    }

    if (!$trigger) {
      $op = new \Club\ShopBundle\Entity\CartProduct();
      $op->setCart($this->cart);
      $op->setProduct($product);
      $op->setProductName($product->getProductName());
      $op->setPrice($product->getPrice());
      $op->setVat($product->getVat()->getRate());
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
      $this->cart->setVatPrice($this->cart->getVatPrice()+$op->getVatPrice());
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
    $this->cart->setPaymentMethod($payment);
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

  public function setCustomerAddress(\Club\UserBundle\Entity\User $user)
  {
    $address = $this->getAddress($user);
    $this->cart->setCustomerAddress($address);
    $this->cart->setShippingAddress($address);
    $this->cart->setBillingAddress($address);
  }

  public function setShippingAddress(\Club\UserBundle\Entity\User $user)
  {
    $address = $this->getAddress($user);
    $this->cart->setShippingAddress($address);
  }

  public function setBillingAddress(\Club\UserBundle\Entity\User $user)
  {
    $address = $this->getAddress($user);
    $this->cart->setBillingAddress($address);
  }

  protected function save()
  {
    $this->em->persist($this->cart);
    $this->em->flush();
  }

  protected function getUserAddress(\Club\UserBundle\Entity\User $user)
  {
    return $this->em->getRepository('ClubUserBundle:Profile')->getDefaultAddress($user->getProfile());
  }

  protected function getAddress(\Club\UserBundle\Entity\User $user)
  {
    $addr = $this->getUserAddress($user);
    return $this->convertAddress($addr);
  }

  protected function convertAddress($addr)
  {
    $address = new \Club\ShopBundle\Entity\CartAddress();
    $address->setFirstName($addr->getProfile()->getFirstName());
    $address->setLastName($addr->getProfile()->getLastName());
    $address->setStreet($addr->getStreet());
    $address->setPostalCode($addr->getPostalCode());
    $address->setCity($addr->getCity());
    $address->setCountry($addr->getCountry()->getCountry());

    return $address;
  }
}
