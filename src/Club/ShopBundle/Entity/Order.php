<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Order")
 * @orm:Table(name="club_shop_order")
 * @orm:HasLifecycleCallbacks
 */
class Order
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
     * @orm:Column(type="string", nullable="true")
     *
     * @var string $order_memo
     */
    private $order_memo;

    /**
     * @orm:Column(type="string")
     *
     * @var string $currency
     */
    private $currency;

    /**
     * @orm:Column(type="decimal")
     *
     * @var string $currency_value
     */
    private $currency_value;

    /**
     * @orm:Column(type="decimal")
     *
     * @var string $price
     */
    private $price;

    /**
     * @orm:ManyToOne(targetEntity="PaymentMethod")
     * @assert:Notblank()
     * @assert:NotBlank(groups={"PaymentMethod"})
     *
     * @var Club\ShopBundle\Entity\PaymentMethod
     */
    private $payment_method;

    /**
     * @orm:ManyToOne(targetEntity="Shipping")
     * @assert:NotBlank()
     *
     * @var Club\ShopBundle\Entity\Shipping
     */
    private $shipping;

    /**
     * @orm:ManyToOne(targetEntity="OrderStatus")
     *
     * @var Club\ShopBundle\Entity\OrderStatus
     */
    private $order_status;

    /**
     * @orm:ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     * @assert:NotBlank()
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    /**
     * @orm:OneToMany(targetEntity="Club\ShopBundle\Entity\OrderProduct", mappedBy="order")
     *
     * @var Club\ShopBundle\Entity\OrderProduct
     */
    private $order_products;

    /**
     * @orm:Column(type="datetime")
     */
    private $created_at;

    public function __construct() {
      $this->order_products = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set tax
     *
     * @param string $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * Get tax
     *
     * @return string $tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set currency
     *
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * Get currency
     *
     * @return string $currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    public function setPrice($price)
    {
      $this->price = $price;
    }

    public function getPrice()
    {
      return $this->price;
    }

    /**
     * Set currency_value
     *
     * @param string $currencyValue
     */
    public function setCurrencyValue($currencyValue)
    {
        $this->currency_value = $currencyValue;
    }

    /**
     * Get currency_value
     *
     * @return string $currencyValue
     */
    public function getCurrencyValue()
    {
        return $this->currency_value;
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

    public function setShipping(\Club\ShopBundle\Entity\Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    public function getShipping()
    {
        return $this->shipping;
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
     * Add orderProduct
     *
     * @param Club\ShopBundle\Entity\OrderProduct $order_products
     */
    public function addOrderProduct(\Club\ShopBundle\Entity\OrderProduct $orderProduct)
    {
        $this->order_products[] = $orderProduct;
    }

    /**
     * Get orderProduct
     *
     * @return Doctrine\Common\Collections\Collection $order_products
     */
    public function getOrderProducts()
    {
        return $this->order_products;
    }

    public function setCreatedAt($createdAt)
    {
      $this->created_at = $createdAt;
    }

    public function getCreatedAt()
    {
      return $this->created_at;
    }

    /**
     * @orm:PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }
}
