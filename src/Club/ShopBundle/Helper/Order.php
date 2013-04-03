<?php

namespace Club\ShopBundle\Helper;

class Order
{
    private $order;
    private $em;
    private $event_dispatcher;
    private $translator;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->event_dispatcher = $container->get('event_dispatcher');
    }

    public function setOrder(\Club\ShopBundle\Entity\Order $order)
    {
        $this->order = $order;
    }

    public function createSimpleOrder(\Club\UserBundle\Entity\User $user, \Club\UserBundle\Entity\Location $location)
    {
        $this->order = new \Club\ShopBundle\Entity\Order();
        $this->order->setOrderStatus($this->getDefaultOrderStatus());
        $this->order->setUser($user);
        $this->setCustomerAddressByUser($user);
        $this->setShippingAddressByUser($user);
        $this->setBillingAddressByUser($user);
        $this->order->setLocation($location);
        $this->setCurrency();
    }

    public function addSimpleProduct(\Club\ShopBundle\Entity\CartProduct $product)
    {
        // will not add product attribute
        $prod = new \Club\ShopBundle\Entity\OrderProduct();

        $prod->setOrder($this->order);
        $prod->setPrice($product->getPrice());
        $prod->setQuantity($product->getQuantity());
        $prod->setProductName($product->getProductName());
        $prod->setType($product->getType());

        $this->order->addOrderProduct($prod);
        $this->em->persist($prod);
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

    public function changeStatus(\Club\ShopBundle\Entity\OrderStatus $order_status)
    {
        $this->order->setOrderStatus($order_status);
        $this->em->persist($this->order);

        $status = new \Club\ShopBundle\Entity\OrderStatusHistory();
        $status->setOrder($this->order);
        $status->setOrderStatus($this->order->getOrderStatus());
        $status->setNote($this->order->getNote());
        $this->em->persist($status);

        if ($order_status->getDelivered()) {
            $this->order->setDelivered(true);
            $this->em->persist($this->order);
        } elseif ($order_status->getPaid()) {
            $this->order->setPaid(true);
            $this->em->persist($this->order);
        } elseif ($order_status->getCancelled()) {
            $this->order->setCancelled(true);
            $this->em->persist($this->order);
        }

        $this->em->flush();

        $event = new \Club\ShopBundle\Event\FilterOrderEvent($this->order);
        $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onOrderChange, $event);
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

    public function recalcPrice()
    {
        $price = 0;

        foreach ($this->order->getOrderProducts() as $product) {
            $price += $product->getPrice()*$product->getQuantity();
        }

        $this->order->setPrice($price);
        $this->order->setAmountLeft($price);
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
        $address->setCountry($addr->getCountry());

        return $address;
    }

    private function createOrder($data)
    {
        $this->order = new \Club\ShopBundle\Entity\Order();
        $this->order->setCurrency($data->getCurrency());
        $this->order->setCurrencyValue($data->getCurrencyValue());
        $this->order->setPrice($data->getPrice());
        $this->order->setAmountLeft($data->getPrice());
        $this->order->setPaymentMethod($this->em->find('ClubShopBundle:PaymentMethod',$data->getPaymentMethod()->getId()));
        $this->order->setShipping($this->em->find('ClubShopBundle:Shipping',$data->getShipping()->getId()));
        $this->order->setOrderStatus($this->getDefaultOrderStatus());
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

        switch (true) {
        case $product->getProduct()->getQuantity() == '0':
            throw new \Club\ShopBundle\Exception\NotInStockException('No more products left');
            break;
        case $product->getProduct()->getQuantity() == '-1':
            break;
        default:
            $quantity = $product->getProduct()->getQuantity()-1;
            $product->getProduct()->setQuantity($quantity);

            $this->em->persist($product->getProduct());
        }

        $this->em->persist($op);
    }

    private function dispatch()
    {
        $event = new \Club\ShopBundle\Event\FilterOrderEvent($this->order);
        $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onShopOrder, $event);
    }

    private function getDefaultOrderStatus()
    {
        return $this->em->getRepository('ClubShopBundle:OrderStatus')->getDefaultStatus();
    }

    /**
     * require that you have set the orer location first, then this will go automatically
     */
    private function setCurrency()
    {
        $currency = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('default_currency',$this->order->getLocation());

        $this->order->setCurrency($currency);
        $this->order->setCurrencyValue(1);
    }

    public function makePayment(\Club\ShopBundle\Entity\PurchaseLog $log)
    {
        $left = $this->order->getAmountLeft()-($log->getAmount()/100);

        $this->order->setAmountLeft($left);
        $this->setPaid();

        $event = new \Club\ShopBundle\Event\FilterPurchaseLogEvent($log);
        $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onPurchaseCreate, $event);
    }

    public function setCancelled()
    {
        $status = $this->em->getRepository('ClubShopBundle:OrderStatus')->getCancelled();
        $this->changeStatus($status);

        $event = new \Club\ShopBundle\Event\FilterOrderEvent($this->order);
        $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onOrderCancelled, $event);
    }

    public function setPaid()
    {
        if ($this->order->getPaid()) return;

        if ($this->order->getAmountLeft() <= 0) {
            $status = $this->em->getRepository('ClubShopBundle:OrderStatus')->getPaid();
            $this->changeStatus($status);
        }

        $this->em->flush();

        if ($this->order->getAmountLeft() > 0) return;

        $delivered = true;
        foreach ($this->order->getProducts() as $prod) {
            if (!preg_match("/(subscription|guest_booking|coupon)/", $prod->getType())) $delivered = false;

            if ($prod->getProduct()) {
                // use for economic bundle
                $prod->setAccountNumber($prod->getProduct()->getAccountNumber());
            }
            $prod->setVoucherText(sprintf(
                $this->container->getParameter('club_shop.voucher_text'),
                $this->order->getUser()->getName(),
                $this->order->getOrderNumber()
            ));
        }

        if ($delivered) {
            $status = $this->em->getRepository('ClubShopBundle:OrderStatus')->getDelivered();
            $this->changeStatus($status);
        }

        $this->em->flush();

        $event = new \Club\ShopBundle\Event\FilterOrderEvent($this->order);
        $this->event_dispatcher->dispatch(\Club\ShopBundle\Event\Events::onOrderPaid, $event);
    }
}
