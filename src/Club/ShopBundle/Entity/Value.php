<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Value")
 * @orm:Table(name="club_shop_value")
 */
class Value
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
     * @var string $product_key
     */
    private $product_key;

    /**
     * @orm:Column(type="string")
     *
     * @var string $product_value
     */
    private $product_value;

    /**
     * @orm:manyToMany(targetEntity="Product")
     *
     * @var Club\ShopBundle\Entity\Product
     */
    private $product;

    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add product
     *
     * @param Club\ShopBundle\Entity\Product $Product
     */
    public function addProduct(\Club\ShopBundle\Entity\Product $Product)
    {
        $this->product[] = $Product;
    }

    /**
     * Get product
     *
     * @return Doctrine\Common\Collections\Collection $Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
