<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Special")
 * @orm:Table(name="club_shop_special")
 *
 */
class Special
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
     * @orm:Column(type="date")
     *
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @orm:Column(type="date")
     *
     * @var datetime $expire_date
     */
    private $expire_date;

    /**
     * @orm:Column(type="decimal")
     *
     * @var float $price
     */
    private $price;

    /**
     * @orm:ManyToOne(targetEntity="Product")
     *
     * @var Club\ShopBundle\Entity\Product
     */
    private $product;


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
