<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopOrder
 */
class ShopOrder
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $order_memo
     */
    private $order_memo;

    /**
     * @var string $order_currency
     */
    private $order_currency;

    /**
     * @var string $order_currency_value
     */
    private $order_currency_value;

    /**
     * @var Club\ShopBundle\Entity\ShopPaymentMethod
     */
    private $shop_payment_method;


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
}