<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopSpecial
 */
class ShopSpecial
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @var datetime $expire_date
     */
    private $expire_date;

    /**
     * @var float $price
     */
    private $price;

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
     * Set start_date
     *
     * @param datetime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
    }

    /**
     * Get start_date
     *
     * @return datetime $startDate
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set expire_date
     *
     * @param datetime $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->expire_date = $expireDate;
    }

    /**
     * Get expire_date
     *
     * @return datetime $expireDate
     */
    public function getExpireDate()
    {
        return $this->expire_date;
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