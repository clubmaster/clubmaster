<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\PaymentMethod")
 * @orm:Table(name="club_shop_payment_method")
 */
class PaymentMethod
{
    /**
     * @orm:id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="string")
     *
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
