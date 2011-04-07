<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopValue
 */
class ShopValue
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $product_key
     */
    private $product_key;

    /**
     * @var string $product_value
     */
    private $product_value;

    /**
     * @var Club\ShopBundle\Entity\ShopProduct
     */
    private $shop_product;

    public function __construct()
    {
        $this->shop_product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set product_key
     *
     * @param string $productKey
     */
    public function setProductKey($productKey)
    {
        $this->product_key = $productKey;
    }

    /**
     * Get product_key
     *
     * @return string $productKey
     */
    public function getProductKey()
    {
        return $this->product_key;
    }

    /**
     * Set product_value
     *
     * @param string $productValue
     */
    public function setProductValue($productValue)
    {
        $this->product_value = $productValue;
    }

    /**
     * Get product_value
     *
     * @return string $productValue
     */
    public function getProductValue()
    {
        return $this->product_value;
    }

    /**
     * Add shop_product
     *
     * @param Club\ShopBundle\Entity\ShopProduct $shopProduct
     */
    public function addShopProduct(\Club\ShopBundle\Entity\ShopProduct $shopProduct)
    {
        $this->shop_product[] = $shopProduct;
    }

    /**
     * Get shop_product
     *
     * @return Doctrine\Common\Collections\Collection $shopProduct
     */
    public function getShopProduct()
    {
        return $this->shop_product;
    }
}