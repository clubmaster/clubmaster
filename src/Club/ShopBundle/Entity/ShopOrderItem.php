<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopOrderItem
 */
class ShopOrderItem
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @var float $price
     */
    private $price;

    /**
     * @var float $tax
     */
    private $tax;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $model
     */
    private $model;

    /**
     * @var Club\ShopBundle\Entity\ShopProduct
     */
    private $shop_product;


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
     * Set shop_product
     *
     * @param Club\ShopBundle\Entity\ShopProduct $shopProduct
     */
    public function setShopProduct(\Club\ShopBundle\Entity\ShopProduct $shopProduct)
    {
        $this->shop_product = $shopProduct;
    }

    /**
     * Get shop_product
     *
     * @return Club\ShopBundle\Entity\ShopProduct $shopProduct
     */
    public function getShopProduct()
    {
        return $this->shop_product;
    }
}