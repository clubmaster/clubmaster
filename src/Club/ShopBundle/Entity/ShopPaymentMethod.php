<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopPaymentMethod
 */
class ShopPaymentMethod
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $payment_method
     */
    private $payment_method;


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
     * Set payment_method
     *
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->payment_method = $paymentMethod;
    }

    /**
     * Get payment_method
     *
     * @return string $paymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }
}