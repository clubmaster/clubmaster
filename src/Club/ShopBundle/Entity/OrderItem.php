<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\OrderItem")
 * @orm:Table(name="club_shop_order_item")
 */
class OrderItem
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
     * @orm:Column(type="integer")
     *
     * @var integer $quantity
     */
    private $quantity;

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
     * @orm:Column(type="string")
     *
     * @var string $name
     */
    private $name;

    /**
     * @orm:Column(type="string")
     *
     * @var string $model
     */
    private $model;

    /**
     * @orm:ManyToOne(targetEntity="Product")
     *
     * @var Club\ShopBundle\Entity\Product
     */
    private $product;

    /**
     * @orm:ManyToOne(targetEntity="Order")
     *
     * @var Club\ShopBundle\Entity\Order
     */
    private $order;


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
     * Set price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
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
     *
     * @return float $tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set model
     *
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Get model
     *
     * @return string $model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set product
     *
     * @param Club\ShopBundle\Entity\Product $Product
     */
    public function setProduct(\Club\ShopBundle\Entity\Product $Product)
    {
        $this->product = $Product;
    }

    /**
     * Get product
     *
     * @return Club\ShopBundle\Entity\Product $Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
