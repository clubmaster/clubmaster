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
     * @var string $payment_method_name
     */
    private $payment_method_name;


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
     * Set payment_method_name
     *
     * @param string $paymentMethodName
     */
    public function setPaymentMethodName($paymentMethodName)
    {
        $this->payment_method_name= $paymentMethodName;
    }

    /**
     * Get payment_method_name
     *
     * @return string $paymentMethodName
     */
    public function getPaymentMethodName()
    {
        return $this->payment_method_name;
    }
}
