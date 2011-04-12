<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Order")
 * @orm:Table(name="club_shop_order")
 */
class Order
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="string")
     *
     * @var string $order_memo
     */
    private $order_memo;

    /**
     * @orm:Column(type="string")
     *
     * @var string $order_currency
     */
    private $order_currency;

    /**
     * @orm:Column(type="decimal")
     *
     * @var string $order_currency_value
     */
    private $order_currency_value;

    /**
     * @orm:ManyToOne(targetEntity="PaymentMethod")
     *
     * @var Club\ShopBundle\Entity\PaymentMethod
     */
    private $payment_method;

    /**
     * @orm:ManyToOne(targetEntity="Shipping")
     *
     * @var Club\ShopBundle\Entity\Shipping
     */
    private $shop_shipping;

    /**
     * @orm:ManyToOne(targetEntity="OrderStatus")
     *
     * @var Club\ShopBundle\Entity\OrderStatus
     */
    private $order_status;

    /**
     * @orm:ManyToOne(targetEntity="Shipping")
     *
     * @var Club\ShopBundle\Entity\Shipping
     */
    private $shipping;

    /**
     * @orm:ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    /**
     * @orm:ManyToOne(targetEntity="Club\ShopBundle\Entity\OrderItem")
     *
     * @var Club\ShopBundle\Entity\OrderItem
     */
    private $items;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set order_memo
     *
     * @param string $orderMemo
     */
    public function setOrderMemo($orderMemo)
    {
        $this->order_memo = $orderMemo;
    }

    /**
     * Get order_memo
     *
     * @return string $orderMemo
     */
    public function getOrderMemo()
    {
        return $this->order_memo;
    }

    /**
     * Set order_currency
     *
     * @param string $orderCurrency
     */
    public function setOrderCurrency($orderCurrency)
    {
        $this->order_currency = $orderCurrency;
    }

    /**
     * Get order_currency
     *
     * @return string $orderCurrency
     */
    public function getOrderCurrency()
    {
        return $this->order_currency;
    }

    /**
     * Set order_currency_value
     *
     * @param string $orderCurrencyValue
     */
    public function setOrderCurrencyValue($orderCurrencyValue)
    {
        $this->order_currency_value = $orderCurrencyValue;
    }

    /**
     * Get order_currency_value
     *
     * @return string $orderCurrencyValue
     */
    public function getOrderCurrencyValue()
    {
        return $this->order_currency_value;
    }

    /**
     * Set payment_method
     *
     * @param Club\ShopBundle\Entity\PaymentMethod $PaymentMethod
     */
    public function setPaymentMethod(\Club\ShopBundle\Entity\PaymentMethod $PaymentMethod)
    {
        $this->payment_method = $PaymentMethod;
    }

    /**
     * Get payment_method
     *
     * @return Club\ShopBundle\Entity\PaymentMethod $PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setShipping(\Club\ShopBundle\Entity\Shipping $shop_shipping)
    {
        $this->shop_shipping = $shop_shipping;
    }

    public function getShipping()
    {
        return $this->shop_shipping;
    }

    public function setOrderStatus(\Club\ShopBundle\Entity\OrderStatus $order_status)
    {
        $this->order_status = $order_status;
    }

    public function getOrderStatus()
    {
        return $this->order_status;
    }

    public function toArray()
    {
      return array(
        'id' => $this->getId(),
        'user_id' => $this->getUser()->getId()
      );
    }

    /**
     * @orm:prePersist
     */
    public function prePersist()
    {
        // Add your code here
    }
}
