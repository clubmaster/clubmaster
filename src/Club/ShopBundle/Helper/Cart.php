<?php

namespace Club\ShopBundle\Helper;

class Cart
{
    protected $cart;
    protected $session;
    protected $em;
    protected $security_context;
    protected $club_user_location;
    protected $token;

    public function __construct($em, $session, $security_context, $club_user_location)
    {
        $this->session = $session;
        $this->em = $em;
        $this->security_context = $security_context;
        $this->club_user_location = $club_user_location;
        $this->token = $security_context->getToken();
    }

    public function getCurrent()
    {
        if ($this->session->get('cart_id') != '') {
            $this->cart = $this->em->find('ClubShopBundle:Cart',$this->session->get('cart_id'));
        }

        if (!$this->cart) {
            if ($this->security_context->isGranted('IS_AUTHENTICATED_FULLY')) {
                $this->cart = $this->em->getRepository('ClubShopBundle:Cart')->findOneBy(
                    array('user' => $this->token->getUser()->getId())
                );
            }

            if (!$this->cart) {
                if ($this->token->getUser() instanceof \Club\UserBundle\Entity\User) {
                    $this->buildCart($this->token->getUser());
                } else {
                    $this->buildCart();
                }

                $this->save();

                $this->session->set('cart_id', $this->cart->getId());
            }
        }

        return $this;
    }

    public function buildCart(\Club\UserBundle\Entity\User $user=null)
    {
        $location = $this->club_user_location->getCurrent();
        $currency = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('default_currency',$location);

        $this->cart = new \Club\ShopBundle\Entity\Cart();
        $this->cart->setSession($this->session->getId());
        $this->cart->setCurrency($currency->getCode());
        $this->cart->setLocation($location);

        if ($user) {
            $this->setUser($user);
        }

        return $this;
    }

    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        if ($this->security_context->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->cart->setUser($user);

            if ($user->getProfile()->getProfileAddress()) {
                $addr = $this->convertAddress($user->getProfile()->getProfileAddress());
                $this->setAddresses($addr);
            }
        }

        return $this;
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
            if ($product->getQuantity() == '0') {
                throw new \Club\ShopBundle\Exception\NotInStockException('No more products left');
            }

            $this->addProductToCart($product);
        } elseif ($product instanceOf \Club\ShopBundle\Entity\CartProduct) {
            $product->setCart($this->cart);
            $this->updateProductToCart($product);
        } else {
            $this->addArrayToCart($product);
        }

        $this->save();
    }

    public function calcCartPrice()
    {
        $price = 0;
        foreach ($this->cart->getCartProducts() as $cart_prod) {
            $price += $cart_prod->getQuantity()*$cart_prod->getPrice();
        }

        $this->cart->setPrice($price);
        $this->save();
    }

    public function updateProductToCart(\Club\ShopBundle\Entity\CartProduct $cart_product)
    {
        $cart_product->setCart($this->cart);
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
        if (!$product->getActive())
            throw new \Exception('You cannot add disabled products to cart.');

        $this->checkLocation($product);

        $trigger = 0;
        // check if its already in the cart
        foreach ($this->cart->getCartProducts() as $prod) {
            if ($prod->getProduct() && $prod->getProduct()->getId() == $product->getId()) {
                if ($prod->getProduct()->getType() == 'subscription') return;

                $prod = $this->modifyQuantity($prod);
                $trigger = 1;
            }
        }

        if (!$trigger) {
            $op = $this->makeCartProduct($product);

            $this->updateProductToCart($op);
        }
    }

    public function makeCartProduct(\Club\ShopBundle\Entity\Product $product)
    {
        $op = new \Club\ShopBundle\Entity\CartProduct();
        $op->setProduct($product);
        $op->setProductName($product->getProductName());
        $op->setPrice($product->getSpecialPrice());
        $op->setQuantity(1);

        $op->setType($product->getType());

        foreach ($product->getProductAttributes() as $attr) {
            $opa = new \Club\ShopBundle\Entity\CartProductAttribute();
            $opa->setCartProduct($op);
            $opa->setValue($attr->getValue());
            $opa->setAttributeName($attr->getAttribute());

            $op->addCartProductAttribute($opa);
        }

        return $op;
    }

    public function emptyCart()
    {
        if ($this->security_context->isGranted('IS_AUTHENTICATED_FULLY')) {
            $cart = $this->em->getRepository('ClubShopBundle:Cart')->findOneBy(
                array('user' => $this->token->getUser()->getId())
            );

            if ($cart) {
                $this->em->remove($cart);
            }
        }

        $carts = $this->em->getRepository('ClubShopBundle:Cart')->findBy(array(
            'session' => $this->session->getId()
        ));

        foreach ($carts as $cart) {
            $this->em->remove($cart);
        }

        $this->em->flush();

        $this->session->set('cart_id', null);
    }

    public function updateShipping()
    {
        foreach ($this->cart->getCartProducts() as $cart_prod) {
            if ($cart_prod->getType() == 'shipping') {
                $this->em->remove($cart_prod);
            }
        }
        $this->em->flush();

        if ($this->cart->getShipping()->getPrice() > 0) {
            $prod = new \Club\ShopBundle\Entity\CartProduct();
            $prod->setType('shipping');
            $prod->setPrice($this->cart->getShipping()->getPrice());
            $prod->setProductName(sprintf('Shipping: %s', $this->cart->getShipping()->getShippingName()));

            $this->addToCart($prod);
        }
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

    public function setAddresses(\Club\ShopBundle\Entity\CartAddress $address)
    {
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

    public function save()
    {
        $this->em->persist($this->cart);
        $this->em->flush();
    }

    protected function convertAddress(\Club\UserBundle\Entity\ProfileAddress $addr)
    {
        $address = new \Club\ShopBundle\Entity\CartAddress();
        $address->setFirstName($addr->getProfile()->getFirstName());
        $address->setLastName($addr->getProfile()->getLastName());
        $address->setStreet($addr->getStreet());
        $address->setPostalCode($addr->getPostalCode());
        $address->setCity($addr->getCity());
        $address->setCountry($addr->getCountry());

        return $address;
    }
}
