<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity
 */
class ShopOrder
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
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
     * @orm:ManyToOne(targetEntity="ShopPaymentMethod")
     *
     * @var Club\ShopBundle\Entity\ShopPaymentMethod
     */
    private $shop_payment_method;

    /**
     * @orm:ManyToOne(targetEntity="ShopShipping")
     *
     * @var Club\ShopBundle\Entity\ShopShipping
     */
    private $shop_shipping;

    /**
     * @orm:ManyToOne(targetEntity="ShopOrderStatus")
     *
     * @var Club\ShopBundle\Entity\ShopOrderStatus
     */
    private $shop_order_status;

    /**
     * @orm:ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    /**
     * @orm:ManyToOne(targetEntity="Club\ShopBundle\Entity\ShopItem")
     *
     * @var Club\ShopBundle\Entity\ShopItem
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
     * Set shop_payment_method
     *
     * @param Club\ShopBundle\Entity\ShopPaymentMethod $shopPaymentMethod
     */
    public function setShopPaymentMethod(\Club\ShopBundle\Entity\ShopPaymentMethod $shopPaymentMethod)
    {
        $this->shop_payment_method = $shopPaymentMethod;
    }

    /**
     * Get shop_payment_method
     *
     * @return Club\ShopBundle\Entity\ShopPaymentMethod $shopPaymentMethod
     */
    public function getShopPaymentMethod()
    {
        return $this->shop_payment_method;
    }

    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setShopShipping(\Club\ShopBundle\Entity\ShopShipping $shop_shipping)
    {
        $this->shop_shipping = $shop_shipping;
    }

    public function getShopShipping()
    {
        return $this->shop_shipping;
    }

    public function setShopOrderStatus(\Club\ShopBundle\Entity\ShopOrderStatus $shop_order_status)
    {
        $this->shop_order_status = $shop_order_status;
    }

    public function getShopOrderStatus()
    {
        return $this->shop_order_status;
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
