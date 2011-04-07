<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopCategory
 */
class ShopCategory
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var text $description
     */
    private $description;

    /**
     * @var Club\ShopBundle\Entity\ShopModule
     */
    private $shop_module;

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
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set shop_module
     *
     * @param Club\ShopBundle\Entity\ShopModule $shopModule
     */
    public function setShopModule(\Club\ShopBundle\Entity\ShopModule $shopModule)
    {
        $this->shop_module = $shopModule;
    }

    /**
     * Get shop_module
     *
     * @return Club\ShopBundle\Entity\ShopModule $shopModule
     */
    public function getShopModule()
    {
        return $this->shop_module;
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