<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\OrderProduct")
 * @orm:Table(name="club_shop_order_product")
 */
class OrderProduct
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
     * @var string $product_name
     */
    private $product_name;

    /**
     * @orm:Column(type="decimal")
     *
     * @var float $price
     */
    private $price;

    /**
     * @orm:Column(type="decimal")
     *
     * @var float $tax
     */
    private $tax;

    /**
     * @orm:Column(type="integer")
     *
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @orm:ManyToOne(targetEntity="Club\ShopBundle\Entity\Product")
     *
     * @var Club\UserBundle\Entity\Product
     */
    private $product;

    /**
     * @orm:ManyToOne(targetEntity="Club\ShopBundle\Entity\Order")
     *
     * @var Club\UserBundle\Entity\Order
     */
    private $order;

    /**
     * @orm:OneToMany(targetEntity="Club\ShopBundle\Entity\OrderProductAttribute", mappedBy="order_product")
     */
    private $order_product_attributes;


    public function __construct()
    {
        $this->order_product_attributes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set product_name
     *
     * @param string $productName
     */
    public function setProductName($productName)
    {
        $this->product_name = $productName;
    }

    /**
     * Get product_name
     *
     * @return string $productName
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Set price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get tax
     * *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set tax
     *
     * @param float $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * Get tax
     * *
     * @return float $tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set order
     *
     * @param string $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return string $order
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function setProduct($product)
    {
      $this->product = $product;
    }

    public function getProduct()
    {
      return $this->product;
    }

    public function addOrderProductAttribute(\Club\ShopBundle\Entity\OrderProductAttribute $orderProductAttribute)
    {
      $this->order_product_attributes[] = $orderProductAttribute;
    }

    public function getOrderProductAttributes()
    {
        return $this->order_product_attributes;
    }
}
