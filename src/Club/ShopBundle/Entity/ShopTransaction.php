<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopTransaction
 */
class ShopTransaction
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $transaction_code
     */
    private $transaction_code;

    /**
     * @var string $transaction_return_value
     */
    private $transaction_return_value;

    /**
     * @var Club\ShopBundle\Entity\ShopTransactionStatus
     */
    private $shop_transaction_status;


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
     * Set transaction_code
     *
     * @param string $transactionCode
     */
    public function setTransactionCode($transactionCode)
    {
        $this->transaction_code = $transactionCode;
    }

    /**
     * Get transaction_code
     *
     * @return string $transactionCode
     */
    public function getTransactionCode()
    {
        return $this->transaction_code;
    }

    /**
     * Set transaction_return_value
     *
     * @param string $transactionReturnValue
     */
    public function setTransactionReturnValue($transactionReturnValue)
    {
        $this->transaction_return_value = $transactionReturnValue;
    }

    /**
     * Get transaction_return_value
     *
     * @return string $transactionReturnValue
     */
    public function getTransactionReturnValue()
    {
        return $this->transaction_return_value;
    }

    /**
     * Set shop_transaction_status
     *
     * @param Club\ShopBundle\Entity\ShopTransactionStatus $shopTransactionStatus
     */
    public function setShopTransactionStatus(\Club\ShopBundle\Entity\ShopTransactionStatus $shopTransactionStatus)
    {
        $this->shop_transaction_status = $shopTransactionStatus;
    }

    /**
     * Get shop_transaction_status
     *
     * @return Club\ShopBundle\Entity\ShopTransactionStatus $shopTransactionStatus
     */
    public function getShopTransactionStatus()
    {
        return $this->shop_transaction_status;
    }
}