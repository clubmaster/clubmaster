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

    if ($this->session->get('cart_id') != '') {
      $this->cart = $this->em->find('ClubShopBundle:Cart',$this->session->get('cart_id'));
    }

    if (!$this->cart) {
      $this->cart = $em->getRepository('ClubShopBundle:Cart')->findOneBy(
        array('user' => $this->user->getId())
      );

      if (!$this->cart) {
        $this->cart = new \Club\ShopBundle\Entity\Cart();
        $this->cart->setUser($this->user);
        $location = $this->user->getLocation();
        $currency = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('default_currency',$location);
        $this->cart->setCurrency($currency);
        $this->cart->setCurrencyValue($currency->getValue());
        $this->cart->setPrice(0);
        $this->cart->setLocation($location);

        if ($this->user->getProfile()->getProfileAddress()) {
          $this->setAddresses($this->user->getProfile()->getProfileAddress());
        }

        $this->save();
      }

      $this->session->set('cart_id',$this->cart->getId());
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
    if ($product instanceOf \Club\ShopBundle\Entity\Product) {
      $this->addProductToCart($product);
    } else {
      $this->addArrayToCart($product);
    }

    $this->save();
  }

  private function updateProductToCart(\Club\ShopBundle\Entity\CartProduct $cart_product)
  {
    $this->cart->addCartProduct($cart_product);
    $this->cart->setPrice($this->cart->getPrice()+$cart_product->getPrice());
  }

  private function addArrayToCart($product)
  {
    $op = new \Club\ShopBundle\Entity\CartProduct();
    $op->setCart($this->cart);
    $op->setProductName($product['product_name']);
    $op->setPrice($product['price']);
    $op->setQuantity(1);
    $op->setType($product['type']);

    $this->updateProductToCart($op);
  }

  public function modifyQuantity(\Club\ShopBundle\Entity\CartProduct $product, $quantity=1)
  {
    if (!($product->getQuantity()+$quantity)) {
      $this->em->remove($product);
    } else {
      $product->setQuantity($product->getQuantity()+$quantity);
    }

    $this->cart->setPrice($this->cart->getPrice()+($product->getPrice()*$quantity));
    $this->save();

    return $product;
  }

  private function addProductToCart(\Club\ShopBundle\Entity\Product $product)
  {
    $this->checkLocation($product);

    $trigger = 0;
    // check if its already in the cart
    foreach ($this->cart->getCartProducts() as $prod) {
      if ($prod->getProduct()->getId() == $product->getId()) {
        $prod = $this->modifyQuantity($prod);
        $trigger = 1;
      }
    }

    if (!$trigger) {
      $op = new \Club\ShopBundle\Entity\CartProduct();
      $op->setCart($this->cart);
      $op->setProduct($product);
      $op->setProductName($product->getProductName());
      $op->setPrice($product->getSpecialPrice());
      $op->setQuantity(1);
      $op->setType('product');

      foreach ($product->getProductAttributes() as $attr) {
        $opa = new \Club\ShopBundle\Entity\CartProductAttribute();
        $opa->setCartProduct($op);
        $opa->setValue($attr->getValue());
        $opa->setAttributeName($attr->getAttribute()->getAttributeName());

        $op->addCartProductAttribute($opa);
      }

      $this->updateProductToCart($op);
    }
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

  public function setAddresses(\Club\UserBundle\Entity\ProfileAddress $address)
  {
    $addr = $this->convertAddress($address);

    $this->cart->setCustomerAddress($addr);
    $this->cart->setShippingAddress($addr);
    $this->cart->setBillingAddress($addr);

    $this->save();
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
