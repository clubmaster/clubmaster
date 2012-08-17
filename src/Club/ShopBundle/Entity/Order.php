<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\OrderRepository")
 * @ORM\Table(name="club_shop_order")
 * @ORM\HasLifecycleCallbacks
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string $order_memo
     */
    protected $order_memo;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string $note
     */
    protected $note;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $currency
     */
    protected $currency;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var string $currency_value
     */
    protected $currency_value;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     * @var string $price
     */
    protected $price;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     * @var string $amount_left
     */
    protected $amount_left;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var string $paid
     */
    protected $paid;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var string $delivered
     */
    protected $delivered;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var string $cancelled
     */
    protected $cancelled;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @Assert\NotBlank(groups={"PaymentMethod"})
     *
     * @var Club\ShopBundle\Entity\PaymentMethod
     */
    protected $payment_method;

    /**
     * @ORM\ManyToOne(targetEntity="Shipping")
     *
     * @var Club\ShopBundle\Entity\Shipping
     */
    protected $shipping;

    /**
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     *
     * @var Club\ShopBundle\Entity\OrderStatus
     */
    protected $order_status;

    /**
     * @var Club\ShopBundle\Entity\OrderStatusHistory
     *
     * @ORM\OneToMany(targetEntity="OrderStatusHistory", mappedBy="order")
     */
    protected $order_status_history;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     * @Assert\NotBlank()
     *
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Club\ShopBundle\Entity\OrderAddress", cascade={"persist"})
     * @Assert\NotBlank()
     *
     * @var Club\ShopBundle\Entity\OrderAddress
     */
    protected $customer_address;

    /**
     * @ORM\ManyToOne(targetEntity="Club\ShopBundle\Entity\OrderAddress", cascade={"persist"})
     * @Assert\NotBlank()
     *
     * @var Club\ShopBundle\Entity\OrderAddress
     */
    protected $shipping_address;

    /**
     * @ORM\ManyToOne(targetEntity="Club\ShopBundle\Entity\OrderAddress", cascade={"persist"})
     * @Assert\NotBlank()
     *
     * @var Club\ShopBundle\Entity\OrderAddress
     */
    protected $billing_address;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\Location")
     *
     * @var Club\UserBundle\Entity\Location
     */
    protected $location;

    /**
     * @ORM\OneToMany(targetEntity="OrderProduct", mappedBy="order", cascade={"persist"})
     *
     * @var Club\ShopBundle\Entity\OrderProduct
     */
    protected $order_products;

    /**
     * @ORM\OneToMany(targetEntity="PurchaseLog", mappedBy="order")
     *
     * @var Club\ShopBundle\Entity\PurchaseLog
     */
    protected $purchase_log;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

    public function __construct() {
      $this->order_products = new \Doctrine\Common\Collections\ArrayCollection();
      $this->order_status_history = new \Doctrine\Common\Collections\ArrayCollection();
      $this->setPaid(false);
      $this->setDelivered(false);
      $this->setCancelled(false);
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
     * Set note
     *
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Get note
     *
     * @return string $note
     */
    public function getNote()
    {
        return $this->note;
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

    public function getProducts()
    {
        return $this->order_products;
    }

    /**
     * Get order_status_history
     *
     * @return Doctrine\Common\Collections\Collection $order_status_history
     */
    public function getOrderStatusHistory()
    {
        return $this->order_status_history;
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
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    public function setCustomerAddress($customer_address)
    {
      $this->customer_address = $customer_address;
    }

    public function getCustomerAddress()
    {
      return $this->customer_address;
    }

    public function setShippingAddress($shipping_address)
    {
      $this->shipping_address = $shipping_address;
    }

    public function getShippingAddress()
    {
      return $this->shipping_address;
    }

    public function setBillingAddress($billing_address)
    {
      $this->billing_address = $billing_address;
    }

    public function getBillingAddress()
    {
      return $this->billing_address;
    }

    public function getOrderNumber()
    {
      return sprintf('%04s',$this->getId());
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Add order_status_history
     *
     * @param Club\ShopBundle\Entity\OrderStatusHistory $orderStatusHistory
     */
    public function addOrderStatusHistory(\Club\ShopBundle\Entity\OrderStatusHistory $orderStatusHistory)
    {
        $this->order_status_history[] = $orderStatusHistory;
    }

    /**
     * Add order_products
     *
     * @param Club\ShopBundle\Entity\OrderProduct $orderProducts
     */
    public function addOrderProducts(\Club\ShopBundle\Entity\OrderProduct $orderProducts)
    {
        $this->order_products[] = $orderProducts;
    }

    /**
     * Set location
     *
     * @param Club\UserBundle\Entity\Location $location
     */
    public function setLocation(\Club\UserBundle\Entity\Location $location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return Club\UserBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set amount_left
     *
     * @param decimal $amountLeft
     */
    public function setAmountLeft($amountLeft)
    {
        $this->amount_left = $amountLeft;
    }

    /**
     * Get amount_left
     *
     * @return decimal
     */
    public function getAmountLeft()
    {
        return $this->amount_left;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * Get paid
     *
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Add purchase_log
     *
     * @param Club\ShopBundle\Entity\PurchaseLog $purchaseLog
     */
    public function addPurchaseLog(\Club\ShopBundle\Entity\PurchaseLog $purchaseLog)
    {
        $this->purchase_log[] = $purchaseLog;
    }

    /**
     * Get purchase_log
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPurchaseLog()
    {
        return $this->purchase_log;
    }

    /**
     * Set delivered
     *
     * @param boolean $delivered
     */
    public function setDelivered($delivered)
    {
        $this->delivered = $delivered;
    }

    /**
     * Get delivered
     *
     * @return boolean
     */
    public function getDelivered()
    {
        return $this->delivered;
    }

    /**
     * Set cancelled
     *
     * @param boolean $cancelled
     */
    public function setCancelled($cancelled)
    {
        $this->cancelled = $cancelled;
    }

    /**
     * Get cancelled
     *
     * @return boolean
     */
    public function getCancelled()
    {
        return $this->cancelled;
    }
}
