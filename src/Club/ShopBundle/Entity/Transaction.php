<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Transaction")
 * @orm:Table(name="club_shop_transaction")
 */
class Transaction
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="string")
     *
     * @var string $transaction_code
     */
    private $transaction_code;

    /**
     * @orm:Column(type="string")
     *
     * @var string $transaction_return_value
     */
    private $transaction_return_value;

    /**
     * @orm:ManyToOne(targetEntity="TransactionStatus")
     *
     * @var Club\ShopBundle\Entity\TransactionStatus
     */
    private $transaction_status;


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
     * Set transaction_status
     *
     * @param Club\ShopBundle\Entity\TransactionStatus $TransactionStatus
     */
    public function setTransactionStatus(\Club\ShopBundle\Entity\TransactionStatus $TransactionStatus)
    {
        $this->transaction_status = $TransactionStatus;
    }

    /**
     * Get transaction_status
     *
     * @return Club\ShopBundle\Entity\TransactionStatus $TransactionStatus
     */
    public function getTransactionStatus()
    {
        return $this->transaction_status;
    }
}
